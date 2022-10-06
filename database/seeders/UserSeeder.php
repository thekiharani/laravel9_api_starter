<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()
            ->create([
                'surname' => 'Example',
                'other_names' => 'Admin Account',
                'email' => 'admin@example.com',
                'phone_number' => '07000000000',
                'account_verified_at' => now(),
            ]);

        \App\Models\User::factory()
            ->create([
                'surname' => 'Example',
                'other_names' => 'Demo Account',
                'email' => 'demo@example.com',
                'phone_number' => '07000000001',
                'account_verified_at' => now(),
            ]);

        \App\Models\User::factory()
            ->create([
                'surname' => 'Example',
                'other_names' => 'Editor Account',
                'email' => 'editor@example.com',
                'phone_number' => '07000000002',
                'account_verified_at' => now(),
            ]);
    }
}
