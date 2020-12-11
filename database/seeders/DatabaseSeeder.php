<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->call([
            MetaSeeder::class,
            RolesAndPermissionsSeeder::class,
            OrganisationsSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
