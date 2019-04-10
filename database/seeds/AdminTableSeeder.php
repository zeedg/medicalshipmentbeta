<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		User::create([
			'name' => 'John Smith',
			'email' => 'johnsmith@gmail.com',
			'password' => Hash::make('password'),
			'remember_token' => str_random(10),
		]);
    }
}
