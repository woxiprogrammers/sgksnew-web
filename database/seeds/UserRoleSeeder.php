<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('user_role')->insert([
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
