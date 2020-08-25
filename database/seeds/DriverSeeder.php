<?php

use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drivers')->insert([
            [
                'name' => 'driver jalur darat',
                'address'=>'jl perpasan',
                'phone'=>'085746575',
                'user_id'=>5,
                'agen_id'=>1,
                'route'=>0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'driver jalur laut',
                'address'=>'jl halimau',
                'phone'=>'08522541236',
                'user_id'=>6,
                'agen_id'=>1,
                'route'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
