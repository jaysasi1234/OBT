<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Create a new Admin account';

    public function handle()
    {
        $user = User::create([
            'name' => 'New Admin',
            'email' => 'kharlchristianlovete@mmacibutuan.edu.ph',
            'username' => 'newadmin',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->info("Admin created successfully.");
        $this->info("Username: {$user->username}");

        return self::SUCCESS;
    }
}