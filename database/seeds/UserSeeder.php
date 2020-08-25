<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'email' => 'admin@mail.com',
                'password'=>Hash::make("123123"),
                'role_id'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'subadmin@mail.com',
                'password'=>Hash::make("123123"),
                'role_id'=>2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'agensumberharapan@mail.com',
                'password'=>Hash::make("123123"),
                'role_id'=>3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'customertitu@mail.com',
                'password'=>Hash::make("123123"),
                'role_id'=>4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'driverdaratsumber@mail.com',
                'password'=>Hash::make("123123"),
                'role_id'=>5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
            ,
            [
                'email' => 'driverlautsumber@mail.com',
                'password'=>Hash::make("123123"),
                'role_id'=>5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
