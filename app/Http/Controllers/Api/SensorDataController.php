<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorDataController extends Controller
{
    /**
     * Receive a POST request and insert into `sensor_readings`, assigning plotID via GPS.
     */
    public function store(Request $request)
    {
        // 1) Validate incoming fields
        $data = $request->validate([
            'soil_moisture' => 'nullable|numeric',
            'temperature'   => 'nullable|numeric',
            'humidity'      => 'nullable|numeric',
            'light'         => 'nullable|numeric',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
        ]);

        // 2) Extract values or null
        $soil = $data['soil_moisture'] ?? null;
        $temp = $data['temperature'] ?? null;
        $hum  = $data['humidity'] ?? null;
        $light= $data['light'] ?? null;
        $lat  = $data['latitude'] ?? null;
        $lon  = $data['longitude'] ?? null;

        // 3) Determine plotID via bounding-box lookup if lat/lon provided
        $plotID = null;
        if (!is_null($lat) && !is_null($lon)) {
            // Query for a plot whose bounding box contains these coords
            $match = DB::selectOne("
                SELECT p.plotID AS plotID
                FROM plots AS p
                WHERE
                    ? BETWEEN p.min_latitude AND p.max_latitude
                    AND ? BETWEEN p.min_longitude AND p.max_longitude
                LIMIT 1
            ", [$lat, $lon]);

            if ($match && isset($match->plotID)) {
                $plotID = $match->plotID;
            }
        }

        // Optionally: if no plot found, you could assign a default, or leave null.
        // For now we leave null if not found; adjust if desired.
        // e.g., $plotID = $plotID ?? 1; // default plot for testing

        // 4) Insert into sensor_readings
        $insertId = DB::table('sensor_readings')->insertGetId([
            'plotID'       => $plotID,
            'soil_moisture'=> $soil,
            'temperature'  => $temp,
            'humidity'     => $hum,
            'light'        => $light,
            'latitude'     => $lat,
            'longitude'    => $lon,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // 5) Return JSON response
        return response()->json([
            'status'      => 'success',
            'inserted_id' => $insertId,
            'plotID'      => $plotID,
        ], 201);
    }
}