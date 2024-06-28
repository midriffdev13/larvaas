<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsPivotTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permissions_pivot')->insert(array (
            0 => 
            array (
                'role_id' => 1,
                'permission_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => 
            array (
                'role_id' => 2,
                'permission_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => 
            array (
                'role_id' => 2,
                'permission_id' => 47,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 => 
            array (
                'role_id' => 2,
                'permission_id' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            4 => 
            array (
                'role_id' => 2,
                'permission_id' => 54,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            5 => 
            array (
                'role_id' => 2,
                'permission_id' => 59,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            6 => 
            array (
                'role_id' => 2,
                'permission_id' => 64,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            7 => 
            array (
                'role_id' => 2,
                'permission_id' => 69,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            8 => 
            array (
                'role_id' => 2,
                'permission_id' => 74,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            9 => 
            array (
                'role_id' => 2,
                'permission_id' => 92,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            10 => 
            array (
                'role_id' => 3,
                'permission_id' => 76,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            11 => 
            array (
                'role_id' => 3,
                'permission_id' => 94,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            12 => 
            array (
                'role_id' => 4,
                'permission_id' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            13 => 
            array (
                'role_id' => 4,
                'permission_id' => 77,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            14 => 
            array (
                'role_id' => 4,
                'permission_id' => 78,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            15 => 
            array (
                'role_id' => 4,
                'permission_id' => 79,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            16 => 
            array (
                'role_id' => 4,
                'permission_id' => 82,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            17 => 
            array (
                'role_id' => 4,
                'permission_id' => 87,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            18 => 
            array (
                'role_id' => 3,
                'permission_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            19 => 
            array (
                'role_id' => 4,
                'permission_id' => 95,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            20 => 
            array (
                'role_id' => 4,
                'permission_id' => 96,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            20 => 
            array (
                'role_id' => 4,
                'permission_id' => 97,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
        
        
    }
}