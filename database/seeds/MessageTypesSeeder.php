<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class MessageTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('message_types')->insert([
            [
                'name' => 'Buzz',
                'slug' => 'buzz',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Dukhad Nidhan',
                'slug' => 'dukhad-nidhan',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Birthday',
                'slug' => 'birthday',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Achievement',
                'slug' => 'achievement',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'General',
                'slug' => 'general',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
