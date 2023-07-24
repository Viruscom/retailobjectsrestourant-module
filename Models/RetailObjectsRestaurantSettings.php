<?php

namespace Modules\RetailObjectsRestourant\Models;

use Illuminate\Database\Eloquent\Model;

class RetailObjectsRestaurantSettings extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];
}
