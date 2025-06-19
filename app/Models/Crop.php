<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    protected $table = 'crops';
    // Default primaryKey is 'id'; if your crops table uses 'id', you're fine.
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true; // if you have created_at/updated_at

    protected $fillable = [
        'name',
        'optimal_moisture_min', 'optimal_moisture_max',
        'optimal_humidity_min', 'optimal_humidity_max',
        'optimal_light_min', 'optimal_light_max',
        'optimal_temperature_min', 'optimal_temperature_max',
    ];

    public function plots()
    {
        return $this->hasMany(Plot::class, 'cropID', 'id');
    }
}
