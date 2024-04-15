<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            WebConfigSeeder::class,
            PermissionSeeder::class
        ]);
        $admin = Admin::create([
            'name' => 'Admin Manager',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Admin@123')
        ]);

        $role1 = Role::create(['name' => 'Admin', 'guard_name' => 'admin']);
        $role2 = Role::create(['name' => 'Sale', 'guard_name' => 'admin']);
        $role3 = Role::create(['name' => 'Content Manager', 'guard_name' => 'admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role1->syncPermissions($permissions);

        $admin->assignRole([$role1->id]);

    }
}
