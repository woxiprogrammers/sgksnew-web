<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class ClassifiedRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('package_rules')->insert([
            [
                'package_id' => 1,
                'package_desc' => 'general',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
