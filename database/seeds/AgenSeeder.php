<?php

use Illuminate\Database\Seeder;

class AgenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agens')->insert([
            [
                'name' => 'PT. Sumber Harapan Mulia',
                'no_agen'=>'999887',
                'address'=>'jl cendana no 1',
                'phone'=>'08523212546',
                'website'=>'www.sumberharapanmulia.com',
                'npwp'=>'122312',
                'user_id'=>3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
