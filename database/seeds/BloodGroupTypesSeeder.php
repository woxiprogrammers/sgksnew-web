<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class BloodGroupTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
       DB::table('blood_group_types')->insert([
            [
                'blood_group_type' => 'A',
                'slug' => 'A',
                'created_at' => $now,
                'updated_at' => $now
            ],
           [
               'blood_group_type' => 'B',
               'slug' => 'B',
               'created_at' => $now,
               'updated_at' => $now
           ],
           [
               'blood_group_type' => 'A-',
               'slug' => 'A-',
               'created_at' => $now,
               'updated_at' => $now
           ],
           [
               'blood_group_type' => 'B-',
               'slug' => 'B-',
               'created_at' => $now,
               'updated_at' => $now
           ],
           [
               'blood_group_type' => 'AB',
               'slug' => 'AB',
               'created_at' => $now,
               'updated_at' => $now
           ],
           [
               'blood_group_type' => 'AB-',
               'slug' => 'AB-',
               'created_at' => $now,
               'updated_at' => $now
           ],
           [
               'blood_group_type' => 'O+',
               'slug' => 'O+',
               'created_at' => $now,
               'updated_at' => $now
           ],
           [
               'blood_group_type' => 'O-',
               'slug' => 'O-',
               'created_at' => $now,
               'updated_at' => $now
           ]
        ]);
    }
}
