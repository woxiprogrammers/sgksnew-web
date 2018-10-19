<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('users')->insert([
            [
                'first_name' => 'Super Admin',
                'last_name' => '',
                'email' => 'superadmin@gmail.com',
                'mobile' => '9898989898',
                'password' => bcrypt('superadmin'),
                'dob' => '',
                'gender' => '',
                'is_active' => 'true',
                'role_id' => '1',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
