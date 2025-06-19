<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Plot;
use App\Models\SensorReading;

class DataMonitoringController extends Controller
{
    /**
     * Display sensor data monitoring page: compute averages in batches of 5 historical readings.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Get all farms belonging to this user
        $farms = $user->farms()->get();

        // 2. For each farm, load its plots (with crop relation)
        $farmPlots = [];
        foreach ($farms as $farm) {
            $farmPlots[$farm->farmID] = $farm->plots()->with('crop')->get();
        }

        // 3. Count total plots across all farms
        $totalPlots = collect($farmPlots)->flatten()->count();

        // 4. Handle filters from query string
        $filterFarmID = $request->query('farm');
        $filterPlotID = $request->query('plot');

        // Determine which plots to include:
        $plotsToProcess = collect();
        if ($filterPlotID) {
            $plot = Plot::with('crop')->where('plotID', $filterPlotID)->first();
            if ($plot) {
                // Ownership check: prefix table to avoid ambiguity
                if ($user->farms()->where('farms.farmID', $plot->farmID)->exists()) {
                    $plotsToProcess->push($plot);
                }
                // else: ignore
            }
        }
        elseif ($filterFarmID) {
            // Check user owns that farm
            if ($user->farms()->where('farms.farmID', $filterFarmID)->exists()) {
                $plotsToProcess = Plot::with('crop')->where('farmID', $filterFarmID)->get();
            }
            // else: leave empty
        }
        else {
            // No filter: include all plots across user's farms
            foreach ($farmPlots as $plots) {
                $plotsToProcess = $plotsToProcess->merge($plots);
            }
        }

        // 5. For each plot, fetch all historical readings, chunk into groups of 5 chronological readings,
        //    compute average and alert per chunk.
        $monitorData = []; // flat array of entries

        foreach ($plotsToProcess as $plot) {
            // Fetch all readings ordered ascending by created_at
            $readings = SensorReading::where('plotID', $plot->plotID)
                ->orderBy('created_at', 'asc')
                ->get();

            if ($readings->isEmpty()) {
                // No readings: push one entry with null averages
                $monitorData[] = [
                    'plot'          => $plot,
                    'batchIndex'    => 1,
                    'avgSoil'       => null,
                    'avgTemp'       => null,
                    'avgHum'        => null,
                    'avgLight'      => null,
                    'lastTimestamp' => null,
                    'alerts'        => [], 
                ];
            } else {
                // Chunk into groups of 5 readings
                $chunks = $readings->chunk(5);
                foreach ($chunks as $idx => $chunk) {
                    // Compute averages ignoring nulls
                    $avgSoil = $chunk->whereNotNull('soil_moisture')->avg('soil_moisture');
                    $avgTemp = $chunk->whereNotNull('temperature')->avg('temperature');
                    $avgHum  = $chunk->whereNotNull('humidity')->avg('humidity');
                    $avgLight= $chunk->whereNotNull('light')->avg('light');
                    // Last timestamp in this chunk:
                    $lastTimestamp = $chunk->last()->created_at;

                    // Determine alerts based on crop thresholds
                    $alerts = [];
                    $crop = $plot->crop;
                    if ($crop) {
                        // Soil moisture
                        if (!is_null($avgSoil)) {
                            if (!is_null($crop->optimal_moisture_min) && $avgSoil < $crop->optimal_moisture_min) {
                                $alerts[] = 'Low Moisture';
                            }
                            if (!is_null($crop->optimal_moisture_max) && $avgSoil > $crop->optimal_moisture_max) {
                                $alerts[] = 'High Moisture';
                            }
                        }
                        // Temperature
                        if (!is_null($avgTemp)) {
                            if (!is_null($crop->optimal_temperature_min) && $avgTemp < $crop->optimal_temperature_min) {
                                $alerts[] = 'Low Temperature';
                            }
                            if (!is_null($crop->optimal_temperature_max) && $avgTemp > $crop->optimal_temperature_max) {
                                $alerts[] = 'High Temperature';
                            }
                        }
                        // Humidity
                        if (!is_null($avgHum)) {
                            if (!is_null($crop->optimal_humidity_min) && $avgHum < $crop->optimal_humidity_min) {
                                $alerts[] = 'Low Humidity';
                            }
                            if (!is_null($crop->optimal_humidity_max) && $avgHum > $crop->optimal_humidity_max) {
                                $alerts[] = 'High Humidity';
                            }
                        }
                        // Light
                        if (!is_null($avgLight)) {
                            if (!is_null($crop->optimal_light_min) && $avgLight < $crop->optimal_light_min) {
                                $alerts[] = 'Low Light';
                            }
                            if (!is_null($crop->optimal_light_max) && $avgLight > $crop->optimal_light_max) {
                                $alerts[] = 'High Light';
                            }
                        }
                    }
                    // If no crop, leave alerts empty => "Normal"

                    $monitorData[] = [
                        'plot'          => $plot,
                        'batchIndex'    => $idx + 1, // 1-based
                        'avgSoil'       => $avgSoil,
                        'avgTemp'       => $avgTemp,
                        'avgHum'        => $avgHum,
                        'avgLight'      => $avgLight,
                        'lastTimestamp' => $lastTimestamp,
                        'alerts'        => $alerts,
                    ];
                }
            }
        }

        return view('datamonitoring', [
            'totalPlots'  => $totalPlots,
            'farms'       => $farms,
            'farmPlots'   => $farmPlots,
            'monitorData' => $monitorData,
        ]);
    }
}
