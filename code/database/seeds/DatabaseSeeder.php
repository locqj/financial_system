<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StoreCostSeeder::class);
        $this->call(StaffContractSeeder::class);
        $this->call(StoreIncomeSeeder::class);
    }
}
