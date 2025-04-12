<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh data admin
        DB::table('admins')->insert([
            [
                'name' => 'Admin One',
                'email' => 'admin1@example.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
