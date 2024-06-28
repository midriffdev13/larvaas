<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AuthorizationTypesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolePermissionsPivotTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserRolesPivotTableSeeder::class);
    }
}
