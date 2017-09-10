<?php

use Illuminate\Database\Seeder;

class StaffContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\StaffContract::class, 30)->create()->each(function($u) {
	    });
    }
}
