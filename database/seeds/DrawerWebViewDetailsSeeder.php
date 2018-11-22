<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class DrawerWebViewDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('drawer_web_view_details')->insert([
            [
                'drawer_web_id' => '1',
                'description' => "<h1>health plus description</h1>",
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'drawer_web_id' => '2',
                'description' => "<h1>privacy policy description</h1>",
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'drawer_web_id' => '3',
                'description' => '<h1>help description</h1>',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'drawer_web_id' => '4',
                'description' => '<h1>qa description</h1>',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'drawer_web_id' => '5',
                'description' => '<h1>contact us description</h1>',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'drawer_web_id' => '6',
                'description' => '<h1>master list description</h1>',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'drawer_web_id' => '7',
                'description' => '<h1>version support description</h1>',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'drawer_web_id' => '8',
                'description' => '<h1>add me to description</h1>',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'drawer_web_id' => '9',
                'description' => '<h1>sgks suggestion description</h1>',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
