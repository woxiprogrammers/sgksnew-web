<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('cities')->insert([
            [
                'name' => 'Pune',
                'state_id' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
