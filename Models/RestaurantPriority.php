<?php

    namespace Modules\RetailObjectsRestourant\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class RestaurantPriority extends Model
    {
        protected $table = 'retail_objects_restaurant_priorities';

        protected $fillable = [
            'ro_id',
            'workload_priority_status',
        ];

        public function restaurant(): BelongsTo
        {
            return $this->belongsTo(RetailObjectsRestourant::class, 'ro_id');
        }
    }
