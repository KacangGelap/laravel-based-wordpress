<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\opd;
class OPDSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opds = [
            'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SDM',
            'BADAN KESBANGPOL',
            'BADAN PENANGGULANGAN BENCANA DAERAH',
            'BADAN PENDAPATAN DAERAH',
            'BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH',
            'BADAN PERENCANAAN, PENELITIAN DAN PENGEMBANGAN',
            'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL',
            'DINAS KESEHATAN',
            'DINAS KOMUNIKASI DAN INFORMATIKA',
            'DINAS KOPERASI UKM DAN PERDAGANGAN',
            'DINAS LINGKUNGAN HIDUP',
            'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG KOTA',
            'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN',
            'DINAS PERHUBUNGAN',
            'DINAS PERPUSTAKAAN DAN KEARSIPAN',
            'DINAS PERUMAHAN,KAWASAN PEMUKIMAN DAN PERTANAHAN',
            'DINAS PMPTSP',
            'DINAS SOSIAL DAN PEMBERDAYAAN MASYARAKAT',
            'INSPEKTORAT DAERAH',
            'KECAMATAN BONTANG BARAT',
            'KECAMATAN BONTANG SELATAN',
            'KECAMATAN BONTANG UTARA',
            'KELURAHAN API-API',
            'KELURAHAN BELIMBING',
            'KELURAHAN BONTANG BARU',
            'KELURAHAN GUNTUNG',
            'KELURAHAN SATIMPO',
            'KELURAHAN TANJUNG LAUT',
            'KELURAHAN TELIHAN',
            'RUMAH SAKIT UMUM DAERAH TAMAN HUSADA'
        ];

        foreach ($opds as $opd) {
            opd::create(['opd' => $opd]);
        }
    }
}
