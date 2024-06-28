<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array (
            0 => 
            array (
                'email' => 'admin@admin.com',
                'email_verified_at' => NULL,
                'guard_name' => NULL,
                'name' => 'Admin',
                'password' => '$2y$12$z8run0IulZXDM5LSbsp89eDKJSdc.t7nDICbU7DM3vySHoT.oTqlK',
                'slug' => 'admin-at-admincom',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
        
        
    }
}