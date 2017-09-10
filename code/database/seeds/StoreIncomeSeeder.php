<?php

use Illuminate\Database\Seeder;

class StoreIncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\StoreIncome::class, 30)->create()->each(function($u) {
	    });
    }
}
