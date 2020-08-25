<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AgenSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(DriverSeeder::class);

    }
}
