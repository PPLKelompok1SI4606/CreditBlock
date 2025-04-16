<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'johndoe@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}