<?php

namespace Database\Seeders;

use App\Models\Drug;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'read appointment']);
        Permission::create(['name' => 'edit appointment']);
        Permission::create(['name' => 'delete appointment']);
        Permission::create(['name' => 'create appointment']);

        Permission::create(['name' => 'read prescription']);
        Permission::create(['name' => 'edit prescription']);
        Permission::create(['name' => 'delete prescription']);
        Permission::create(['name' => 'create prescription']);

        Permission::create(['name' => 'read patient']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'doctor']);
        $role1->givePermissionTo('read prescription');
        $role1->givePermissionTo('edit prescription');
        $role1->givePermissionTo('delete prescription');
        $role1->givePermissionTo('create prescription');

        $role1->givePermissionTo('read patient');

        $role2 = Role::create(['name' => 'receptionist']);
        $role2->givePermissionTo('read appointment');
        $role2->givePermissionTo('edit appointment');
        $role2->givePermissionTo('delete appointment');
        $role2->givePermissionTo('create appointment');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Doctor',
            'email' => 'doctor@example.com',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Receptionist',
            'email' => 'receptionist@example.com',
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
        ]);
        $user->assignRole($role3);
        $user = \App\Models\User::factory()->create([
            'name' => 'Doctor 1',
            'email' => 'doctor1@example.com',
        ]);
        $user->assignRole($role1);

        Drug::factory()->count(500)->create();

    }
}
