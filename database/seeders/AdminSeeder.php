<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@obt.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('OBTadmin'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
