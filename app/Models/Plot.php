<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    protected $table = 'plots';
    protected $primaryKey = 'plotID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'farmID',
        'name',
        'min_latitude',
        'max_latitude',
        'min_longitude',
        'max_longitude',
    ];

    /**
     * A Plot belongs to a Farm.
     */
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farmID', 'farmID');
    }

    /**
     * (Optional) A Plot has many SensorReadings
     */
    public function sensorReadings()
    {
        return $this->hasMany(SensorReading::class, 'plotID', 'plotID');
    }
}
