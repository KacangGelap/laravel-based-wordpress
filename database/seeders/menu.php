<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class Menu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            ['menu' => 'TENTANG'],
            ['menu' => 'PROGRAM KERJA'],
            ['menu' => 'INFORMASI'],
            ['menu' => 'LAYANAN'],
        ]);
        DB::table('kategori')->insert([
            ['kategori' => 'Kegiatan'],
            ['kategori' => 'Informasi'],
            ['kategori' => 'Apel Pagi'],
            ['kategori' => 'Kerja Bakti'],
        ]);
        DB::table('filecat')->insert([
            ['cat' => 'Peraturan'],
            ['cat' => 'SOP'],
            ['cat' => 'Alur Pelayanan'],
            ['cat' => 'Pamflet Edukasi'],
        ]);
    }
}
