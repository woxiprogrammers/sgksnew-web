<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class SuggestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('suggestion_types')->insert([
            [
                'name' => 'Suggestion',
                'slug' => 'suggestion',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Complaint',
                'slug' => 'complaint',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
