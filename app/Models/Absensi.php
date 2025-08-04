<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Absensi extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'nama',
        'email',
        'no_telpon',
        'minat',
        'tanggal'
    ];
}