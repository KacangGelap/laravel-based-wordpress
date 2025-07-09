<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class carousel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('advanced_carousel_category')->insert([
            ['kategori' => 'Sumber Daya Manusia'],
            ['kategori' => 'Sarana'],
            ['kategori' => 'Prasarana'],
        ]);
    }
}
