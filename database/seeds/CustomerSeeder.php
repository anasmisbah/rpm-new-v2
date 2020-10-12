<?php

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'name' => 'PT. Titu Perkasa Energi',
                'no_customer'=>'985940',
                'address'=>'jl perjuangan no 1',
                'member'=>'gold',
                'phone'=>'08523212546',
                'website'=>'www.perkasa.com',
                'npwp'=>'45684',
                'agen_id'=>1,
                'user_id'=>4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
