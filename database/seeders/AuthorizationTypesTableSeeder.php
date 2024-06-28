<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorizationTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('authorization_types')->insert(array (
            0 => 
            array (
                'name' => 'Global',
                'description' => 'Global authorization type',
                'slug' => 'global',
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => 
            array (
                'name' => 'Team',
                'description' => 'Team authorization type',
                'slug' => 'team',
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => 
            array (
                'name' => 'Team Member',
                'description' => 'Team member authorization type',
                'slug' => 'team-member',
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
        
        
    }
}