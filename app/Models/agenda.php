<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agenda extends Model
{
    use HasFactory;
    protected $table = 'kalender';

    protected $fillable = [
        'mulai',
        'selesai',
        'nama_kegiatan',
        'penyelenggara',
        'lokasi',
        'alamat',   
        'menghadiri'
    ];
}
