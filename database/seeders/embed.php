<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class embed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('page_embed_category')->insert([
            ['kategori' => 'Inovasi'],
            ['kategori' => 'Survei Kepuasan Masyarakat (SKM)'],
        ]);
    }
}
