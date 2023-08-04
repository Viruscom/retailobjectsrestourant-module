<?php

namespace Modules\RetailObjectsRestourant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Models\Admin\Products\Product;

class ProductAdditivePivot extends Model
{
    protected $table = 'product_additive_pivot';

    protected $fillable = [
        'product_additive_id',
        'product_id',
        'price',
        'quantity',
        'in_without_list'
    ];

    public function productAdditive(): BelongsTo
    {
        return $this->belongsTo(ProductAdditive::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
