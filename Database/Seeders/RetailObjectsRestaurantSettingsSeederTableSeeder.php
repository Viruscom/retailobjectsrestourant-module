<?php

namespace Modules\RetailObjectsRestourant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\RetailObjectsRestourant\Models\RetailObjectsRestaurantSettings;

class RetailObjectsRestaurantSettingsSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RetailObjectsRestaurantSettings::create([
                                                    'key'   => 'google_maps_api_key',
                                                    'value' => '',
                                                ]);
    }
}
