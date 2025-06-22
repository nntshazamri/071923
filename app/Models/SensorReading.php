<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    // Table name is sensor_readings by default, so no need to set $table explicitly
    // If your primary key is the default 'id', you don’t need to override $primaryKey.

    // Allow mass assignment of these fields, now including plotID:
    protected $fillable = [
        'plotID',        // new field referencing the plot
        'soil_moisture',
        'temperature',
        'humidity',
        'light',
        'latitude',
        'longitude',
    ];

    // If you want automatic casting to floats for latitude/longitude and numeric fields:
    protected $casts = [
        'soil_moisture' => 'float',
        'temperature'   => 'float',
        'humidity'      => 'float',
        'light'         => 'float',
        'latitude'      => 'float',
        'longitude'     => 'float',
        'plotID'        => 'integer', // or 'integer'/'string' depending on your needs
    ];

    /**
     * Relationship: a SensorReading belongs to a Plot.
     * Assumes you have a Plot model with primaryKey 'plotID'.
     */

    public function plot()
{
    return $this->belongsTo(\App\Models\Plot::class, 'plotID', 'plotID');
}
}
