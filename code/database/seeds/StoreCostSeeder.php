<?php

use Illuminate\Database\Seeder;

class StoreCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\StoreCost::class, 30)->create()->each(function($u) {
	    });
    }
}
