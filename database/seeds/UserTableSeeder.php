<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Md.Admin',
            'username' => 'admin',
            'email'=>'admin@mail.com',
            'password' => Hash::make('1234')
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Md.Author',
            'username' => 'author',
            'email'=>'author@mail.com',
            'password' => Hash::make('1234')
        ]);
    }
}
