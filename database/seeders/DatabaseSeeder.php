<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $managerRole = Role::create(['name' => 'manager', 'guard_name' => 'web']);
        $revisorRole = Role::create(['name' => 'revisor', 'guard_name' => 'web']);

        // Create a user with the manager role
        User::factory()->withRole('manager')->create([
            'name' => 'Chief Manager',
            'email' => 'manager@laravelba.com',
            'password' => Hash::make('manager'),
        ]);

        // Create a user with the revisor role
        User::factory()->withRole('revisor')->create([
            'name' => 'Chief Revisor',
            'email' => 'revisor@laravelba.com',
            'password' => Hash::make('revisor'),
        ]);

        // Create permissions
        Permission::create(['name' => 'product-list']);
        Permission::create(['name' => 'product-create']);
        Permission::create(['name' => 'product-edit']);
        Permission::create(['name' => 'product-delete']);
        Permission::create(['name' => 'user-list']);
        Permission::create(['name' => 'user-create']);
        Permission::create(['name' => 'user-edit']);
        Permission::create(['name' => 'user-delete']);

        //Assign permissions
        $managerRole->givePermissionTo(
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete'
        );
        $revisorRole->givePermissionTo(
            'product-list',
        );
    }
}
