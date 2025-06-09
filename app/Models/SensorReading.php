<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    // If your table is named sensor_readings (plural),
    // Eloquent will pick it up automatically.
    // Otherwise uncomment and set explicitly:
    protected $table = 'sensor_readings';

    // Allow mass assignment of these fields:
    protected $fillable = [
        'soil_moisture',
        'temperature',
        'humidity',
        'light',
        'latitude',
        'longitude',
    ];
}