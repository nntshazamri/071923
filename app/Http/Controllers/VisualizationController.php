<?php
// app/Http/Controllers/VisualizationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\Farm;
use App\Models\Plot;
use App\Models\SensorReading;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class VisualizationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1) get all user farms (with their name/location)
        $farms = $user->farms()->get();

        // 2) build plots list if farm filter is set
        $plots = collect();
        if ($request->filled('farm')) {
            $plots = Plot::where('farmID', $request->farm)->get();
        }

        // 3) query sensor readings with filters
        $q = SensorReading::query();
        if ($request->filled('farm')) {
            $plotIDs = Plot::where('farmID', $request->farm)->pluck('plotID');
            $q->whereIn('plotID', $plotIDs);
        }
        if ($request->filled('plot')) {
            $q->where('plotID', $request->plot);
        }
        if ($request->filled('start_date')) {
            $q->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $q->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $q->orderBy('created_at')->get();

        // 4) group logs by date and compute daily averages
        $grouped = $logs->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        $labels = [];
        $soilData = [];
        $tempData = [];
        $humData = [];
        $lightData = [];

        foreach ($grouped as $date => $items) {
            $labels[] = $date;
            $soilData[] = round($items->avg('soil_moisture'), 2);
            $tempData[] = round($items->avg('temperature'), 2);
            $humData[] = round($items->avg('humidity'), 2);
            $lightData[] = round($items->avg('light'), 2);
        }

        return view('visualize.index', compact(
            'farms',
            'plots',
            'labels',
            'soilData',
            'tempData',
            'humData',
            'lightData'
        ));
    }

    public function exportCsv(Request $request)
    {
        $readings = $this->getFilteredReadings($request);
        $filename = 'sensor_data_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function () use ($readings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Farm', 'Plot', 'Soil Moisture', 'Temperature', 'Humidity', 'Light']);

            foreach ($readings as $r) {
                $farmName = optional($r->plot->farm)->location ?? 'N/A';
                $plotName = optional($r->plot)->name ?? 'N/A';

                fputcsv($file, [
                    $r->created_at,
                    $farmName,
                    $plotName,
                    $r->soil_moisture,
                    $r->temperature,
                    $r->humidity,
                    $r->light,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $readings = $this->getFilteredReadings($request);

        $pdf = Pdf::loadView('visualize.pdf', compact('readings'));
        return $pdf->download('sensor_data_' . now()->format('Ymd_His') . '.pdf');
    }

    // ✅ This is the missing method that filters readings
    private function getFilteredReadings(Request $request)
    {
        $q = SensorReading::with('plot.farm');

        if ($request->filled('farm')) {
            $plotIDs = Plot::where('farmID', $request->farm)->pluck('plotID');
            $q->whereIn('plotID', $plotIDs);
        }

        if ($request->filled('plot')) {
            $q->where('plotID', $request->plot);
        }

        if ($request->filled('start_date')) {
            $q->whereDate('created_at', '>=', $request->start_date);
        }   

        if ($request->filled('end_date')) {
            $q->whereDate('created_at', '<=', $request->end_date);
        }

        return $q->orderBy('created_at')->get();
    }
}

