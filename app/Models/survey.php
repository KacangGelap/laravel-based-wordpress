<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class survey extends Model
{
    use HasFactory;
    protected $table = 'survey_kepuasan_layanan';
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'usia',
        'email',
        'kategori_responden',
        'pelayanan',
        'kecepatan_pelayanan',
        'kesesuaian_informasi',
        'kualitas_pelayanan',
        'saran',
    ];
}
