<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keberatan extends Model
{
    use HasFactory;
    protected $table = 'ajuan_keberatan';
    protected $fillable = [
        'kode_ajuan',
        'alasan_keberatan',
        'nama_pemohon',
        'alamat',
        'hp_pemohon',
        'rincian_keberatan',
        'identitas',
        'status'
    ];
}
