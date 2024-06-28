<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(array (
            0 => 
            array (
                'name' => 'Developer',
                'description' => 'Developer role',
                'slug' => 'developer',
                'is_active' => 1,
                'team_id' => NULL,
                'authorization_type_id' => 1,
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => 
            array (
                'name' => 'Administrator',
                'description' => 'Administrator role',
                'slug' => 'administrator',
                'is_active' => 1,
                'team_id' => NULL,
                'authorization_type_id' => 1,
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => 
            array (
                'name' => 'Moderator',
                'description' => 'Moderator role',
                'slug' => 'moderator',
                'is_active' => 1,
                'team_id' => NULL,
                'authorization_type_id' => 1,
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 => 
            array (
                'name' => 'User',
                'description' => 'user role',
                'slug' => 'user',
                'is_active' => 1,
                'team_id' => NULL,
                'authorization_type_id' => 1,
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            4 => 
            array (
                'name' => 'Affiliate',
                'description' => 'Affiliate role',
                'slug' => 'affiliate',
                'is_active' => 1,
                'team_id' => NULL,
                'authorization_type_id' => 1,
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            5 => 
            array (
                'name' => 'Team Owner',
                'description' => 'Team owner role',
                'slug' => 'team-owner',
                'is_active' => 1,
                'team_id' => NULL,
                'authorization_type_id' => 3,
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            6 => 
            array (
                'name' => 'Team Moderator',
                'description' => 'Team moderator role',
                'slug' => 'team-moderator',
                'is_active' => 1,
                'team_id' => NULL,
                'authorization_type_id' => 3,
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            7 => 
            array (
                'name' => 'Team Member',
                'description' => 'Team member role',
                'slug' => 'team-member',
                'is_active' => 1,
                'team_id' => NULL,
                'authorization_type_id' => 3,
                'deleted_at' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
        
        
    }
}