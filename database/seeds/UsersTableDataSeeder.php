<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name'     => 'admin name',
        //     'email'    => 'iterview@admin.com',
        //     'role'     => 'admin',
        //     'password' => bcrypt('password')
        // ]);
        for ($i=0; $i < 100; $i++) { 
	    	User::create([
	            'name' => str_random(8),
	            'email' => str_random(12).'@mail.com',
	            'password' => bcrypt('123456')
	        ]);
    	}
    }
}
