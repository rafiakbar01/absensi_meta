<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

     // Nama tabel yang sebenarnya di database
    protected $table = 'absensis'; // <-- GANTI sesuai nama tabel kamu
    
    protected $fillable = [
        'nama',
        'email',
        'no_telpon',
        'minat',
        'custom_minat'
    ];
}