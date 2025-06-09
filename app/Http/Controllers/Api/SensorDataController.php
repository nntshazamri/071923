<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorReading;      // 1) Import your model
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    /**
     * Receive a POST request and insert into `sensor_readings`.
     */
    public function store(Request $request)
    {
        // 2) Validate incoming fields
        $data = $request->validate([
            'soil_moisture' => 'nullable|numeric',
            'temperature'   => 'nullable|numeric',
            'humidity'      => 'nullable|numeric',
            'light'         => 'nullable|numeric',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
        ]);

        // 3) Create a new record in sensor_readings via Eloquent
        $reading = SensorReading::create($data);

        // 4) Return a JSON response including the new record’s ID & timestamp
        return response()->json([
            'status'      => 'success',
            'inserted_id' => $reading->id,
            'inserted_at' => $reading->created_at->toDateTimeString(),
        ], 201);
    }
}
