<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class DrawerWebViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('drawer_web_view')->insert([
            [
                'name' => 'Health Plus',
                'slug' => 'health-plus',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'Help',
                'slug' => 'help',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'QA',
                'slug' => 'qa',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'Contact Us',
                'slug' => 'contact-us',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'Version Support',
                'slug' => 'version-support',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'Add Me To SGKS',
                'slug' => 'add-me-to-sgks',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'SGKS Suggestion',
                'slug' => 'sgks-suggestion',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
