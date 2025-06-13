<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'userID'; // Important because your PK is userID

    protected $fillable = [
        'name',
        'email',
        'phoneNo',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function farms()
    {
        return $this->belongsToMany(
            Farm::class,
            'user_farms',
            'userID',
            'farmID'
        );
    }
}


