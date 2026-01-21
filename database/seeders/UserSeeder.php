<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ================= ADMIN =================
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama'     => 'Administrator',
                'password' => Hash::make('admin'),
                'role'     => 'admin',
            ]
        );

        // ================= GURU =================
        $userGuru = User::firstOrCreate(
            ['username' => 'guru'],
            [
                'nama'     => 'Guru Test',
                'password' => Hash::make('guru'),
                'role'     => 'guru',
            ]
        );

        Guru::firstOrCreate(
            ['user_id' => $userGuru->id],
            [
                'nama' => 'Guru Test',
                'nip'  => '1987654321',
            ]
        );
    }
}
