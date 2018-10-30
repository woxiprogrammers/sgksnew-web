<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class LanguageSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('languages')->insert([
            [
                'name' => 'English',
                'abbreviation' => 'en',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'Gujarati',
                'abbreviation' => 'gj',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
