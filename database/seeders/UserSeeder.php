<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //    
        $users = array(
            array(
                'username' => 'maeron',
                'password' => hash::make('123'),
                'first_name' => 'Maeron Joseph',
                'middle_name' => 'A',
                'last_name' => 'Reyes',
                'user_type' => 'employee',
            ),
            array(
                'username' => 'admin',
                'password' => hash::make('admin'),
                'first_name' => 'Adminstrator',
                'middle_name' => '',
                'last_name' => 'MISO',
                'user_type' => 'admin',
            ),
        );
        DB::table('tbl_users')->insert($users);    
    }
}
