<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    protected $table = 'plots';

    // Primary key in your table is plotID, not id.
    protected $primaryKey = 'plotID';
    public $incrementing = true;
    protected $keyType = 'int';

    // Timestamps: if your table has created_at/updated_at columns, leave default.
    public $timestamps = true;

    // Allow mass assignment:
    protected $fillable = [
        'farmID',
        'cropID',
        'name',
        'min_latitude',
        'max_latitude',
        'min_longitude',
        'max_longitude',
    ];

    // Relationship: Plot belongsTo Crop
    public function crop()
    {
        // foreign key cropID in plots, references id in crops
        return $this->belongsTo(Crop::class, 'cropID', 'id');
    }

    // Relationship: Plot belongsTo Farm
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farmID', 'farmID');
    }

    // Relationship: readings
    public function readings()
    {
        return $this->hasMany(SensorReading::class, 'plotID', 'plotID');
    }
    
}
