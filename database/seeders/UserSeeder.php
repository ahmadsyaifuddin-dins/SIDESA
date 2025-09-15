<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Membuat Super Administrator
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@gmail.com',
            'jabatan' => 'Developer',
            'password' => Hash::make('password'), // password nya: password
            'role' => 'superadmin',
            'status' => 'Aktif',
            'email_verified_at' => now(),
        ]);
        
        // Membuat Admin Operator
        User::create([
            'name' => 'Ahmad Syaifuddin',
            'email' => 'admin@gmail.com',
            'jabatan' => 'Operator Data',
            'password' => Hash::make('password'), // password nya: password
            'role' => 'admin',
            'status' => 'Aktif',
            'email_verified_at' => now(),
        ]);
    }
}