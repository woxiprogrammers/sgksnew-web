<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class SuggestionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('suggestion_categories')->insert([
            [
                'name' => 'Social',
                'slug' => 'social',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Cultural',
                'slug' => 'cultural',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Managing Committee',
                'slug' => 'managing-committee',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Education Committee',
                'slug' => 'education-committee',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Event',
                'slug' => 'event',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Other',
                'slug' => 'other',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
