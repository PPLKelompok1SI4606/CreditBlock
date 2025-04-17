<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user if not exists
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            UserSeeder::class,
            LoanApplicationSeeder::class,
            PaymentSeeder::class,
        ]);

        // Only run AdminSeeder if no admins exist
        if (\DB::table('admins')->count() === 0) {
            $this->call(AdminSeeder::class);
        } else {
            $this->command->info('Admin records already exist - skipping AdminSeeder');
        }
    }
}