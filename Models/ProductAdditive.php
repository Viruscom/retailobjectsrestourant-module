<?php

namespace Modules\RetailObjectsRestourant\Models;

use App\Helpers\CacheKeysHelper;
use App\Traits\CommonActions;
use App\Traits\StorageActions;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Modules\Shop\Models\Admin\Products\Product;

class ProductAdditive extends Model implements TranslatableContract
{
    use Translatable, StorageActions, CommonActions;

    public array $translatedAttributes = ['title'];
    protected    $table                = 'product_additives';
    protected    $fillable             = ['price'];
    public static function cacheUpdate()
    {
        Cache::forget(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES);

        return Cache::rememberForever(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES, static function () {
            return self::with('translations')->get();
        });
    }

    public static function getRequestData($request): array
    {
        return [
            'price' => $request->price
        ];
    }

    public static function getLangArraysOnStore($data, $request, $languages, $modelId, $isUpdate)
    {
        foreach ($languages as $language) {
            $data[$language->code] = ProductAdditiveTranslation::getLanguageArray($language, $request, $modelId, $isUpdate);
        }

        return $data;
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
