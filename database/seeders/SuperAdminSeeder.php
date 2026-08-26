<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
    ['email' => 'SuperAdmin@obt.com'],
    [
        'name' => 'Super Admin',
        'username' => 'superadmin',
        'password' => Hash::make('OBTsuperadmin'),
        'role' => 'dean',
    ]
);
    }
}