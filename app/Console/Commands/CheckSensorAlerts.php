<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Plot;
use App\Models\Alert;
use App\Models\Crop;
use Illuminate\Support\Facades\Mail;

class CheckSensorAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan alerts:check
     *
     * @var string
     */
    protected $signature = 'alerts:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check latest sensor readings (rolling avg of last 5) against crop thresholds and create/resolve alerts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting sensor alert check...");

        // 4. Rolling-average SQL: last 5 readings per plot
        // NOTE: adjust table/column names if different.
        $sql = "
            SELECT plotID,
                   AVG(soil_moisture) AS avg_soil,
                   AVG(temperature)   AS avg_temp,
                   AVG(humidity)      AS avg_hum,
                   AVG(light)         AS avg_light
            FROM (
                SELECT plotID, soil_moisture, temperature, humidity, light, created_at,
                       ROW_NUMBER() OVER (PARTITION BY plotID ORDER BY created_at DESC) AS rn
                FROM sensor_readings
                WHERE plotID IS NOT NULL
            ) AS t
            WHERE t.rn <= 5
            GROUP BY plotID
        ";

        $results = DB::select($sql);

        foreach ($results as $row) {
            $plotID = $row->plotID;
            // Load plot with crop and users of farm if needed
            $plot = Plot::with(['crop', 'farm.users'])->where('plotID', $plotID)->first();
            if (!$plot) {
                // No such plot (maybe deleted); skip
                continue;
            }
            if (!$plot->crop) {
                // No crop assigned -> cannot check thresholds
                continue;
            }
            $crop = $plot->crop;

            // Prepare metrics to check
            $metrics = [
                'soil_moisture' => [
                    'avg' => $row->avg_soil,
                    'min' => $crop->optimal_moisture_min,
                    'max' => $crop->optimal_moisture_max,
                    'label' => 'Moisture',
                ],
                'temperature' => [
                    'avg' => $row->avg_temp,
                    'min' => $crop->optimal_temperature_min,
                    'max' => $crop->optimal_temperature_max,
                    'label' => 'Temperature',
                ],
                'humidity' => [
                    'avg' => $row->avg_hum,
                    'min' => $crop->optimal_humidity_min,
                    'max' => $crop->optimal_humidity_max,
                    'label' => 'Humidity',
                ],
                'light' => [
                    'avg' => $row->avg_light,
                    'min' => $crop->optimal_light_min,
                    'max' => $crop->optimal_light_max,
                    'label' => 'Light',
                ],
            ];

            foreach ($metrics as $metric => $info) {
                $avgValue = $info['avg'];
                $min = $info['min'];
                $max = $info['max'];
                $label = $info['label'];

                if (is_null($avgValue)) {
                    // No readings for this metric -> skip
                    continue;
                }
                // If both min and max null, skip
                if (is_null($min) && is_null($max)) {
                    continue;
                }

                $outOfRange = false;
                $type = null;
                $thresholdDesc = null;

                if (!is_null($min) && $avgValue < $min) {
                    $outOfRange = true;
                    $type = "Low {$label}";
                    $thresholdDesc = "<" . number_format($min, 2);
                }
                if (!is_null($max) && $avgValue > $max) {
                    $outOfRange = true;
                    $type = "High {$label}";
                    $thresholdDesc = ">" . number_format($max, 2);
                }

                if ($outOfRange) {
                    // Check if there is an existing unresolved alert for this plot & metric
                    $existing = Alert::where('plotID', $plotID)
                        ->where('metric', $metric)
                        ->whereNull('resolved_at')
                        ->orderByDesc('occurred_at')
                        ->first();
                    if ($existing) {
                        // Already an unresolved alert -> do nothing
                        continue;
                    }
                    // Create new alert
                    $alert = Alert::create([
                        'plotID'    => $plotID,
                        'metric'    => $metric,
                        'type'      => $type,
                        'avg_value' => $avgValue,
                        'threshold' => $thresholdDesc,
                        'occurred_at' => now(),
                    ]);
                    $this->info("New alert for plot {$plotID}: {$type} (avg={$avgValue}, thr={$thresholdDesc})");

                    // SEND EMAIL to farm owners (example)
                    try {
                        $farmUsers = $plot->farm->users; // collection of user models
                        foreach ($farmUsers as $user) {
                            // Example: use a Mailable `\App\Mail\PlotAlertMail`
                            // Mail::to($user->email)->send(new \App\Mail\PlotAlertMail($alert));
                            // For now just log:
                            $this->info("Would send email to {$user->email} about alert {$alert->id}");
                        }
                        // Mark sent_email_at
                        $alert->sent_email_at = now();
                        $alert->save();
                    } catch (\Exception $e) {
                        $this->error("Failed sending email for alert {$alert->id}: {$e->getMessage()}");
                    }

                } else {
                    // In-range: check if there is an unresolved alert to resolve
                    $prev = Alert::where('plotID', $plotID)
                        ->where('metric', $metric)
                        ->whereNull('resolved_at')
                        ->orderByDesc('occurred_at')
                        ->first();
                    if ($prev) {
                        $prev->resolved_at = now();
                        $prev->save();
                        $this->info("Resolved alert {$prev->id} for plot {$plotID}, metric {$metric}");
                    }
                }
            }
        }

        $this->info("Sensor alert check completed.");
        return 0;
    }
}
