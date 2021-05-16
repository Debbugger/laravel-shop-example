<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['id' => 1],['name' => 'admin']);
        Role::firstOrCreate(['id' => 2],['name' => 'user']);
        User::find(1)->assignRole('admin');
    }
}
