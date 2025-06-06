<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SensorDataController extends Controller
{
    /**
     * Receive a POST request and insert into `sensor_readings`.
     */
    public function store(Request $request)
    {
        // Validate incoming fields (all nullable; we’ll cast to floats if present)
        $data = $request->validate([
            'soil_moisture' => 'nullable|numeric',
            'temperature'   => 'nullable|numeric',
            'humidity'      => 'nullable|numeric',
            'light'         => 'nullable|numeric',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
        ]);

        // Build raw SQL with placeholders
        $sql = "
            INSERT INTO `sensor_readings`
            (`soil_moisture`, `temperature`, `humidity`, `light`, `latitude`, `longitude`, `created_at`, `updated_at`)
            VALUES
            (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ";

        // Cast each key to float or NULL if missing
        $vals = [
            array_key_exists('soil_moisture', $data) ? floatval($data['soil_moisture']) : null,
            array_key_exists('temperature',   $data) ? floatval($data['temperature'])   : null,
            array_key_exists('humidity',      $data) ? floatval($data['humidity'])      : null,
            array_key_exists('light',         $data) ? floatval($data['light'])         : null,
            array_key_exists('latitude',      $data) ? floatval($data['latitude'])      : null,
            array_key_exists('longitude',     $data) ? floatval($data['longitude'])     : null,
        ];

        DB::insert($sql, $vals);

        // Return a simple JSON response
        return response()->json([
            'status' => 'success',
            'inserted_at' => now()->toDateTimeString(),
        ]);
    }
}
