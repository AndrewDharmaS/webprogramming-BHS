<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => "Member",
            'email' => "member@gmail.com",
            'password' => Hash::make('member123'),
            'role' => 'member'
        ]);
    }
}
