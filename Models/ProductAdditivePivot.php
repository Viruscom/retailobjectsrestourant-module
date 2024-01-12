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
        'in_without_list',
    ];
    public static function updateAdditives(Product $product, array $selectedAdditives, array $selectedAdditivesWithoutList)
    {
        self::storeAdditive($product, $selectedAdditives, false);
        self::storeAdditive($product, $selectedAdditivesWithoutList, true);
    }

    protected static function storeAdditive($product, $list, $isWithoutList)
    {
        foreach ($list as $additiveId) {
            $additive = ProductAdditive::find($additiveId);
            if (is_null($additive)) {
                continue;
            }
            ProductAdditivePivot::create([
                                             'product_additive_id' => $additive->id,
                                             'product_id'          => $product->id,
                                             'price'               => $additive->price,
                                             'in_without_list'     => $isWithoutList,
                                         ]);
        }
    }

    public function productAdditive(): BelongsTo
    {
        return $this->belongsTo(ProductAdditive::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
