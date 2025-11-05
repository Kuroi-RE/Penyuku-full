<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // User dengan role penangkaran
        User::create([
            'name' => 'Admin Penangkaran',
            'username' => 'admin',
            'email' => 'admin@penangkaran.com',
            'password' => Hash::make('password'),
            'role' => 'penangkaran',
        ]);

        // User dengan role komunitas
        User::create([
            'name' => 'User Komunitas',
            'username' => 'user1',
            'email' => 'user1@komunitas.com',
            'password' => Hash::make('password'),
            'role' => 'komunitas',
        ]);

        User::create([
            'name' => 'User Komunitas 2',
            'username' => 'user2',
            'email' => 'user2@komunitas.com',
            'password' => Hash::make('password'),
            'role' => 'komunitas',
        ]);
    }
}