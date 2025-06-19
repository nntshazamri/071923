<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'alerts';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'plotID',
        'metric',
        'type',
        'avg_value',
        'threshold',
        'occurred_at',
        'sent_email_at',
        'resolved_at',
    ];

    // If you want timestamp columns managed manually:
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function plot()
    {
        return $this->belongsTo(Plot::class, 'plotID', 'plotID');
    }
}
