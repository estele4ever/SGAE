<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //
        User::create([
            'name' => 'Admin',
            'email' => 'estelengnemie@gmail.com',
            'role' => 'admin', 
            'service' => 'admin',
            'permission' => 'all', // Permissions pour l'administrateur
            'password' => Hash::make('12345678'), 
        ]);
    }
}
