<?php

namespace Modules\RetailObjectsRestourant\Models\DeliveryZones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\RetailObjectsRestourant\Models\RetailObjectsRestourant;

class DeliveryZone extends Model
{
    protected $table    = "restaurant_delivery_zone";
    protected $fillable = ['ro_id', 'polygon'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(RetailObjectsRestourant::class, 'ro_id', 'id');
    }
}
