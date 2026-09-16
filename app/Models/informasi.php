<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\opd;
class informasi extends Model
{
    use HasFactory;
    protected $table = 'permohonan_informasi';
    protected $fillable = [
        'kode_permohonan',
        'kategori_permohonan',
        'opd_id',
        'nama_pemohon',
        'jenis_identitas',
        'nomor_identitas',
        'alamat_pemohon',
        'pekerjaan_pemohon',
        'hp_pemohon',
        'rincian_kebutuhan',
        'tujuan_informasi',
        'cara_memperoleh_informasi',
        'cara_mendapatkan_informasi',
        'identitas'
    ];
    public function opd()
    {
        return $this->belongsTo(opd::class, 'opd_id');
    }
}

