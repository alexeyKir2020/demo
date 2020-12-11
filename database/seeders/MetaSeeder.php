<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        /*
        *   cities seeding
        */
        $cities = file_get_contents(database_path() . '/seeders/cities.sql');
        DB::statement($cities);

        $organisation_types = [
            ['id' => 1, 'name' => 'Некоммерческая'],
            ['id' => 2, 'name' => 'Коммерческая'],
            ['id' => 3, 'name' => 'ИП'],
        ];

        DB::table('organisation_types')->insert($organisation_types);
    }
}
