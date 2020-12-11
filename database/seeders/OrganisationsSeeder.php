<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organisation;

class OrganisationsSeeder extends Seeder
{
    public function run()
    {
        Organisation::factory(10)->create();
    }
}
