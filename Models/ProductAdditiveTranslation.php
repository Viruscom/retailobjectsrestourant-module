<?php

namespace Modules\RetailObjectsRestourant\Models;

use App\Interfaces\Models\CommonModelTranslationInterfaces;
use App\Models\Language;
use App\Traits\StorageActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAdditiveTranslation extends Model implements CommonModelTranslationInterfaces
{
    use StorageActions;

    protected $table    = "product_additive_translation";
    protected $fillable = ['locale', 'product_additive_id', 'title'];
    public static function getLanguageArray($language, $request, $modelId, $isUpdate): array
    {
        return [
            'locale' => $language->code,
            'title'  => $request['title_' . $language->code],
        ];
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductAdditive::class, 'product_additive_id');
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
