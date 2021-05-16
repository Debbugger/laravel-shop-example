<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::firstOrCreate(['id' => 1], ['name' => 'openAdminPanel']);
        Role::find(1)->givePermissionTo($permission);
    }
}
