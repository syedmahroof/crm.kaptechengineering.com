<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions to remove
        $permissionsToRemove = [
            // Itinerary permissions
            'view itineraries',
            'create itineraries',
            'edit itineraries',
            'delete itineraries',
            'manage master itineraries',
            
            // Attraction permissions
            'view attractions',
            'create attractions',
            'edit attractions',
            'delete attractions',
            
            // Hotel permissions
            'view hotels',
            'create hotels',
            'edit hotels',
            'delete hotels',
            
            // Blog permissions
            'view blogs',
            'create blogs',
            'edit blogs',
            'delete blogs',
        ];

        // Delete permissions
        foreach ($permissionsToRemove as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission) {
                // Remove permission from all roles first
                $permission->roles()->detach();
                // Delete the permission
                $permission->delete();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Recreate the permissions
        $permissionsToCreate = [
            // Itinerary permissions
            'view itineraries',
            'create itineraries',
            'edit itineraries',
            'delete itineraries',
            'manage master itineraries',
            
            // Attraction permissions
            'view attractions',
            'create attractions',
            'edit attractions',
            'delete attractions',
            
            // Hotel permissions
            'view hotels',
            'create hotels',
            'edit hotels',
            'delete hotels',
            
            // Blog permissions
            'view blogs',
            'create blogs',
            'edit blogs',
            'delete blogs',
        ];

        foreach ($permissionsToCreate as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }
    }
};
