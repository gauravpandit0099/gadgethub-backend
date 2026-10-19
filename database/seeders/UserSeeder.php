<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gadgethub.com'],
            [
                'name' => 'GadgetHub Admin',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gadgethub.com'],
            [
                'name' => 'GadgetHub User',
                'password' => Hash::make('User@123'),
                'role' => 'user',
            ]
        );
    }
}