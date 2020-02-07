<?php

use Illuminate\Database\Seeder;
use App\ReservedInfo;

class ReservedInfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(ReservedInfo::class, 1)
        ->create();
    }
}
