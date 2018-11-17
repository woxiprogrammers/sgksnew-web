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
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Nidhan',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Birthday',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Achievement',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'General',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
