<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::firstOrCreate(['id' => 1], ['name' => 'admin', 'email' => 'admin@seed', 'password' => '123321','phone'=>'+380631133793']);
    }
}
