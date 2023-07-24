<?php

namespace Modules\RetailObjectsRestourant\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RetailObjectsRestourantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RetailObjectsRestaurantSettingsSeederTableSeeder::class);
    }
}
