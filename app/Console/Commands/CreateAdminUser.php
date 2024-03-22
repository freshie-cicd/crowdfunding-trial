<?php

namespace App\Console\Commands;

use App\Models\Administrator as Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin {name} {email} {role} {password}';
    protected $description = 'Creates a new admin user';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $role = $this->argument('role');
        $password = $this->argument('password');

        $admin = Admin::create([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'password' => Hash::make($password),
        ]);

        $this->info("Admin user {$admin->name} created successfully.");
    }
}
