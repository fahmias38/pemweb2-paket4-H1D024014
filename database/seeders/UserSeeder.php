<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default Admin
        User::create([
            'name'     => 'Admin CleanPro',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Default Kasir
        User::create([
            'name'     => 'Kasir CleanPro',
            'email'    => 'kasir@example.com',
            'password' => Hash::make('password'),
            'role'     => 'kasir',
        ]);
    }
}
