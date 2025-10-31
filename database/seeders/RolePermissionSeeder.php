<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view leads',
            'create leads',
            'edit leads',
            'delete leads',
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin - has all permissions
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - has most permissions
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo([
            'view leads', 'create leads', 'edit leads', 'delete leads',
            'view products', 'create products', 'edit products', 'delete products',
            'view users', 'create users', 'edit users',
        ]);

        // Sales Manager - can manage leads and products
        $salesManager = Role::create(['name' => 'Sales Manager']);
        $salesManager->givePermissionTo([
            'view leads', 'create leads', 'edit leads', 'delete leads',
            'view products', 'create products', 'edit products',
        ]);

        // Sales Executive - can view and create leads
        $salesExecutive = Role::create(['name' => 'Sales Executive']);
        $salesExecutive->givePermissionTo([
            'view leads', 'create leads', 'edit leads',
            'view products',
        ]);

        // Create default Super Admin user
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('Super Admin');

        // Create a Sales Manager user
        $manager = User::create([
            'name' => 'Sales Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('Sales Manager');

        // Create a Sales Executive user
        $executive = User::create([
            'name' => 'Sales Executive',
            'email' => 'sales@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $executive->assignRole('Sales Executive');

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Default users created:');
        $this->command->info('- admin@example.com / password (Super Admin)');
        $this->command->info('- manager@example.com / password (Sales Manager)');
        $this->command->info('- sales@example.com / password (Sales Executive)');
    }
}
