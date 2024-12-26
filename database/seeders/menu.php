<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class menu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create(['menu' => 'TENTANG']);
        Menu::create(['menu' => 'PROGRAM KERJA']);
        Menu::create(['menu' => 'PPID']);
        Menu::create(['menu' => 'INFORMASI']);
    }
}
