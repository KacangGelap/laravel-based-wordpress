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
    }
}
