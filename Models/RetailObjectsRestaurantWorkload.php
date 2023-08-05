<?php

namespace Modules\RetailObjectsRestourant\Models;

use Illuminate\Database\Eloquent\Model;

class RetailObjectsRestaurantWorkload extends Model
{
    public const WORKLOAD_STATUS_WEAK           = 1;
    public const WORKLOAD_STATUS_MODERATELY     = 2;
    public const WORKLOAD_STATUS_STRONG         = 3;
    public const WORKLOAD_STATUS_VERY_STRONG    = 4;
    public const WORKLOAD_STATUS_CLOSED         = 5;
    public const WORKLOAD_STATUS_ORDERS_STOPPED = 6;

    protected $table    = 'retail_objects_restaurant_workload';
    protected $fillable = ['ro_id', 'day_of_week', 'workload_status', 'from_hour', 'to_hour', 'has_extraordinary_status', 'extraordinary_status'];
    public static function cacheUpdate()
    {

    }
    public static function getWorkloadStatuses(): array
    {
        return [
            self::WORKLOAD_STATUS_WEAK,
            self::WORKLOAD_STATUS_MODERATELY,
            self::WORKLOAD_STATUS_STRONG,
            self::WORKLOAD_STATUS_VERY_STRONG,
            self::WORKLOAD_STATUS_CLOSED,
        ];
    }
}
