<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class ClassifiedPackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('classified_packages')->insert([
            [
                'package_name' => 'General',
                'slug' => 'general',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
