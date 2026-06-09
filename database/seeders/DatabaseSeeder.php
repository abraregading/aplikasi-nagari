<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'nik' => null,
            ]
        );

        // Operator
        User::updateOrCreate(
            ['username' => 'operator'],
            [
                'name' => 'Operator Nagari',
                'email' => 'operator@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'operator',
                'nik' => null,
            ]
        );

        // Kepala Jorong
        User::updateOrCreate(
            ['username' => 'kajor'],
            [
                'name' => 'Kepala Jorong',
                'email' => 'kajor@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'kajor',
                'nik' => null,
            ]
        );

        // Warga (contoh)
        User::updateOrCreate(
            ['username' => 'warga'],
            [
                'name' => 'Warga Nagari',
                'email' => 'warga@siyanduk.test',
                'password' => Hash::make('password123'),
                'role' => 'warga',
                'nik' => null,
            ]
        );
    }
}
