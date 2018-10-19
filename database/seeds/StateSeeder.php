<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('states')->insert([
            [
                'name' => 'Maharashtra',
                'country_id' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Gujarat',
                'country_id' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
