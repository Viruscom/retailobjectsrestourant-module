<?php

namespace Modules\RetailObjectsRestourant\Models;

use App\Helpers\CacheKeysHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class RetailObjectsRestaurantWorkload extends Model
{
    public const WORKLOAD_STATUS_WEAK           = 1;
    public const WORKLOAD_STATUS_MODERATELY     = 2;
    public const WORKLOAD_STATUS_STRONG         = 3;
    public const WORKLOAD_STATUS_VERY_STRONG    = 4;
    public const WORKLOAD_STATUS_CLOSED         = 5;
    public const WORKLOAD_STATUS_ORDERS_STOPPED = 6;

    protected $table    = 'retail_objects_restaurant_workload';
    protected $fillable = ['day_of_week', 'from_hour', 'to_hour', 'has_extraordinary_status', 'extraordinary_status'];
    public static function cacheUpdate()
    {
        Cache::forget(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES);

        return Cache::rememberForever(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES, static function () {
            return self::with('translations')->get();
        });
    }
}
