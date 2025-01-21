<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
class init extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the application is not in production
        if (!app()->isProduction()) {
            $password = env('ADMIN_PASSWORD', '_default_password_here');
            \App\Models\User::factory()->create([
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make($password),
                'role' => 'admin',
                'opd' => 'Diskominfo',
            ]);
        }
    }
}
