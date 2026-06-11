<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Super Admin
            [
                'name' => 'SuperAdministrator',
                'username' => 'super admin',
                'email' => 'superadmin@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'nik' => '0000000000000001',
                'jorong' => null,
                'status' => 'approved',
            ],
            // Admin
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'nik' => '0000000000000001',
                'jorong' => null,
                'status' => 'approved',
            ],

            // Operator
            [
                'name' => 'Operator Nagari',
                'username' => 'operator',
                'email' => 'operator@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'operator',
                'nik' => '0000000000000011',
                'jorong' => null,
                'status' => 'approved',
            ],
            [
                'name' => 'Operator 2',
                'username' => 'operator2',
                'email' => 'operator2@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'operator',
                'nik' => '0000000000000012',
                'jorong' => null,
                'status' => 'approved',
            ],

            // Kepala Jorong
            [
                'name' => 'Kajor Pasir Putih',
                'username' => 'kajor1',
                'email' => 'kajor1@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'kajor',
                'nik' => '0000000000000021',
                'jorong' => 'Pasir Putih',
                'status' => 'approved',
            ],
            [
                'name' => 'Kajor Lubuk Jambi',
                'username' => 'kajor2',
                'email' => 'kajor2@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'kajor',
                'nik' => '0000000000000022',
                'jorong' => 'Lubuk Jambi',
                'status' => 'approved',
            ],

            // Petugas
            [
                'name' => 'Petugas Pasir Putih',
                'username' => 'petugas1',
                'email' => 'petugas1@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
                'nik' => '0000000000000031',
                'jorong' => 'Pasir Putih',
                'status' => 'approved',
            ],
            [
                'name' => 'Petugas Lubuk Jambi',
                'username' => 'petugas2',
                'email' => 'petugas2@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
                'nik' => '0000000000000032',
                'jorong' => 'Lubuk Jambi',
                'status' => 'approved',
            ],
            [
                'name' => 'Petugas Koto Baru',
                'username' => 'petugas3',
                'email' => 'petugas3@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
                'nik' => '0000000000000033',
                'jorong' => 'Koto Baru',
                'status' => 'approved',
            ],

            // Warga
            [
                'name' => 'Ahmad Syahputra',
                'username' => 'warga1',
                'email' => 'warga1@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'warga',
                'nik' => '1301010101010001',
                'jorong' => 'Pasir Putih',
                'status' => 'approved',
            ],
            [
                'name' => 'Siti Rahmawati',
                'username' => 'warga2',
                'email' => 'warga2@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'warga',
                'nik' => '1301010101010002',
                'jorong' => 'Lubuk Jambi',
                'status' => 'approved',
            ],
            [
                'name' => 'Budi Santoso',
                'username' => 'warga3',
                'email' => 'warga3@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'warga',
                'nik' => '1301010101010003',
                'jorong' => 'Koto Baru',
                'status' => 'approved',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                $user
            );
        }

        $this->command->info('Seeder User: ' . count($users) . ' users created.');
    }
}
