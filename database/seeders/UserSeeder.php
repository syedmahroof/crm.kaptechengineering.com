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
            [
                'name' => 'John Anderson',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role' => 'Sales Executive',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'role' => 'Sales Executive',
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael@example.com',
                'password' => Hash::make('password'),
                'role' => 'Sales Executive',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@example.com',
                'password' => Hash::make('password'),
                'role' => 'Sales Manager',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'password' => Hash::make('password'),
                'role' => 'Sales Executive',
            ],
            [
                'name' => 'Jessica Martinez',
                'email' => 'jessica@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Robert Taylor',
                'email' => 'robert@example.com',
                'password' => Hash::make('password'),
                'role' => 'Sales Executive',
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa@example.com',
                'password' => Hash::make('password'),
                'role' => 'Sales Manager',
            ],
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);
            
            $user = User::create(array_merge($userData, [
                'email_verified_at' => now(),
            ]));
            
            $user->assignRole($role);
        }

        $this->command->info('Additional users created successfully!');
        $this->command->info('All users have password: password');
    }
}

