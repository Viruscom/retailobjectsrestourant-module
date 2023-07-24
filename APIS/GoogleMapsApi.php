<?php

namespace Modules\RetailObjectsRestourant\APIS;

use Modules\RetailObjectsRestourant\Models\RetailObjectsRestaurantSettings;

class GoogleMapsApi
{
    protected static $instance;
    private string   $API_KEY = '';

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
    public function getApiKey()
    {
        if ($this->API_KEY == '') {
            return $this->setApiKey();
        }

        return $this->API_KEY;
    }
    public function setApiKey()
    {
        $setting = RetailObjectsRestaurantSettings::where('google_maps_api_key', '!=', '')->first();
        if (is_null($setting)) {
            return json_encode(['error' => 'Google Maps API Key is not set!']);
        }
        $this->API_KEY = $setting->value;
    }
}
