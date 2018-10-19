<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('countries')->insert([
            [
                'sortname' => 'IND',
                'name' => 'India',
                'phonecode' => 91,
                'is_active' => true,
                'created_at' => $now,
               'updated_at' => $now
            ],
        ]);
    }
}
