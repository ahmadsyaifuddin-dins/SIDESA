<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Untuk data Indonesia

        // Membuat Super Administrator
        User::create([
            'nik' => '1234567890123456',
            'name' => 'Super Administrator',
            'email' => 'superadmin@gmail.com',
            'jabatan' => 'Developer',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2004-06-09',
            'alamat' => 'Jl. Desa Anjir Muara No. 1',
            'no_hp' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'status' => 'Aktif',
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'profile_photo_path' => null,
            'remember_token' => null,
        ]);
        
        // Membuat Admin Operator
        User::create([
            'nik' => '9876543210987654',
            'name' => 'Ahmad Syaifuddin',
            'email' => 'admin@gmail.com',
            'jabatan' => 'Operator Data',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2004-06-09',
            'alamat' => 'Jl. Merdeka No. 45, Anjir Muara',
            'no_hp' => '081298765432',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'Aktif',
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'profile_photo_path' => null,
            'remember_token' => null,
        ]);

        // Data admin perempuan
        User::create([
            'nik' => '1122334455667788',
            'name' => 'Siti Rahayu',
            'email' => 'siti.rahayu@gmail.com',
            'jabatan' => 'Staff Administrasi',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '1993-08-22',
            'alamat' => 'Jl. Melati No. 12, RT 02, Anjir Muara',
            'no_hp' => '082144433322',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'Aktif',
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'profile_photo_path' => null,
            'remember_token' => null,
        ]);

        // Data pimpinan (Kepala Desa)
        User::create([
            'nik' => '9988776655443322',
            'name' => 'Amrullah, S. A. P',
            'email' => 'amrullah.sap@gmail.com',
            'jabatan' => 'Kepala Desa',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1975-12-10',
            'alamat' => 'Jl. Kenanga No. 8, Anjir Muara',
            'no_hp' => '081355566677',
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
            'status' => 'Aktif',
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'profile_photo_path' => null,
            'remember_token' => null,
        ]);

        // Generate 10 data dummy admin/pimpinan lainnya
        for ($i = 1; $i <= 10; $i++) {
            $gender = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $role = $faker->randomElement(['admin', 'admin', 'admin', 'pimpinan']); // 75% admin, 25% pimpinan
            
            User::create([
                'nik' => $faker->numerify('################'),
                'name' => $faker->name($gender == 'Laki-laki' ? 'male' : 'female'),
                'email' => $faker->unique()->safeEmail,
                'jabatan' => $role == 'pimpinan' 
                    ? $faker->randomElement(['Kepala Desa', 'Sekretaris Desa', 'Bendahara Desa'])
                    : $faker->randomElement(['Operator Data', 'Staff Administrasi', 'Petugas Lapangan']),
                'jenis_kelamin' => $gender,
                'tanggal_lahir' => $faker->date('Y-m-d', $role == 'pimpinan' ? '-40 years' : '-30 years'),
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
                'password' => Hash::make('password'),
                'role' => $role,
                'status' => $faker->randomElement(['Aktif', 'Aktif', 'Aktif', 'Tidak Aktif']), // 75% aktif
                'email_verified_at' => now(),
                'last_login_at' => $faker->optional(0.7)->dateTimeThisYear, // 70% kemungkinan punya last login
                'profile_photo_path' => null,
                'remember_token' => $faker->optional(0.3)->regexify('[A-Za-z0-9]{20}'), // 30% kemungkinan punya remember token
            ]);
        }
    }
}