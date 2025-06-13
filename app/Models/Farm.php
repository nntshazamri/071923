<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    // Table name and primary key:
    protected $table = 'farms';
    protected $primaryKey = 'farmID';
    public $incrementing = true;
    protected $keyType = 'int';

    // Mass-assignable fields (ensure these columns exist in your `farms` table)
    protected $fillable = [
        'location',
        // 'size',   // Uncomment if you added a `size` column via migration
    ];

    /**
     * Many-to-many relation: a Farm belongs to many Users.
     * Pivot table: user_farms, columns userID, farmID
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_farms',
            'farmID',
            'userID'
        );
    }

    /**
     * One-to-many: a Farm has many Plots.
     */
    public function plots()
    {
        return $this->hasMany(Plot::class, 'farmID', 'farmID');
    }
}
