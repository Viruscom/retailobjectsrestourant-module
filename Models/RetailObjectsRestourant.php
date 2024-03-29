<?php

    namespace Modules\RetailObjectsRestourant\Models;

    use App\Helpers\AdminHelper;
    use App\Helpers\CacheKeysHelper;
    use App\Helpers\FileDimensionHelper;
    use App\Helpers\SeoHelper;
    use App\Interfaces\Models\CommonModelInterface;
    use App\Interfaces\Models\ImageModelInterface;
    use App\Models\Seo;
    use App\Traits\CommonActions;
    use App\Traits\HasGallery;
    use App\Traits\Scopes;
    use App\Traits\StorageActions;
    use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
    use Astrotomic\Translatable\Translatable;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    use Modules\RetailObjectsRestourant\Models\DeliveryZones\DeliveryZone;

    class RetailObjectsRestourant extends Model implements TranslatableContract, CommonModelInterface, ImageModelInterface
    {
        use Translatable, Scopes, StorageActions, CommonActions, HasGallery;

        public const FILES_PATH = "images/retail_objects_restaurant";

        public static string $RETAIL_OBJECT_SYSTEM_IMAGE  = "retailobjectsrestourant_1_image.png";
        public static string $RETAIL_OBJECT_RATIO         = '3/2';
        public static string $RETAIL_OBJECT_MIMES         = 'jpg,jpeg,png,gif';
        public static string $RETAIL_OBJECT_MAX_FILE_SIZE = '3000';

        public array $translatedAttributes  = ['title', 'url', 'announce', 'description', 'visible', 'address', 'email', 'phone', 'map_iframe'];
        protected    $table                 = "retail_objects_restaurant";
        protected    $fillable              = ['filename', 'position', 'active', 'working_time_mon_fri', 'working_time_saturday', 'working_time_sunday'];
        protected    $translationForeignKey = 'ro_id';

        public static function cacheUpdate(): void
        {
            cache()->forget(CacheKeysHelper::$RETAIL_OBJECT_RESTAURANT_ADMIN);
            cache()->forget(CacheKeysHelper::$RETAIL_OBJECT_RESTAURANT_FRONT);
            cache()->rememberForever(CacheKeysHelper::$RETAIL_OBJECT_RESTAURANT_ADMIN, function () {
                return self::with('translations')->orderBy('position')->get();
            });
            cache()->rememberForever(CacheKeysHelper::$RETAIL_OBJECT_RESTAURANT_FRONT, function () {
                return self::active(true)->with('translations')->orderBy('position')->get();
            });
        }
        public static function getRequestData($request)
        {
            if ($request->has('email')) {
                $data['email'] = $request->email;
            }

            if ($request->has('phone')) {
                $data['phone'] = $request->phone;
            }

            $data['active'] = false;
            if ($request->has('active')) {
                $data['active'] = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
            }

            if ($request->has('filename')) {
                $data['filename'] = $request->filename;
            }

            if ($request->hasFile('image')) {
                $data['filename'] = pathinfo(CommonActions::getValidFilenameStatic($request->image->getClientOriginalName()), PATHINFO_FILENAME) . '.' . $request->image->getClientOriginalExtension();
            }

            if ($request->has('working_time_mon_fri')) {
                $data['working_time_mon_fri'] = $request->working_time_mon_fri;
            }

            if ($request->has('working_time_saturday')) {
                $data['working_time_saturday'] = $request->working_time_saturday;
            }

            if ($request->has('working_time_sunday')) {
                $data['working_time_sunday'] = $request->working_time_sunday;
            }

            return $data;
        }
        public static function getLangArraysOnStore($data, $request, $languages, $modelId, $isUpdate)
        {
            foreach ($languages as $language) {
                $data[$language->code] = RetailObjectsRestourantTranslation::getLanguageArray($language, $request, $modelId, $isUpdate);
            }

            return $data;
        }
        public static function getFileRules(): string
        {
            return FileDimensionHelper::getRules('RetailObjectsRestourant', 1);
        }
        public static function getUserInfoMessage(): string
        {
            return FileDimensionHelper::getUserInfoMessage('RetailObjectsRestourant', 1);
        }

        public function setKeys($array): array
        {
            $array[1]['sys_image_name'] = trans('retailobjectsrestourant::admin.index');
            $array[1]['sys_image']      = self::$RETAIL_OBJECT_SYSTEM_IMAGE;
            $array[1]['sys_image_path'] = AdminHelper::getSystemImage(self::$RETAIL_OBJECT_SYSTEM_IMAGE);
            $array[1]['ratio']          = self::$RETAIL_OBJECT_RATIO;
            $array[1]['mimes']          = self::$RETAIL_OBJECT_MIMES;
            $array[1]['max_file_size']  = self::$RETAIL_OBJECT_MAX_FILE_SIZE;
            $array[1]['file_rules']     = 'mimes:' . self::$RETAIL_OBJECT_MIMES . '|size:' . self::$RETAIL_OBJECT_MAX_FILE_SIZE . '|dimensions:ratio=' . self::$RETAIL_OBJECT_RATIO;

            return $array;
        }
        public function getSystemImage(): string
        {
            return AdminHelper::getSystemImage(self::$RETAIL_OBJECT_SYSTEM_IMAGE);
        }
        public function getFilepath($filename): string
        {
            return $this->getFilesPath() . $filename;
        }
        public function getFilesPath(): string
        {
            return self::FILES_PATH . '/' . $this->id . '/';
        }
        public function getAnnounce(): string
        {
            return Str::limit($this->announce, 255, ' ...');
        }
        public function headerGallery()
        {
            return $this->getHeaderGalleryRelation(get_class($this));
        }
        public function mainGallery()
        {
            return $this->getMainGalleryRelation(get_class($this));
        }
        public function seoFields()
        {
            return $this->hasOne(Seo::class, 'model_id')->where('model', get_class($this));
        }
        public function seo($languageSlug)
        {
            $seo = $this->seoFields;
            if (is_null($seo)) {
                return null;
            }
            SeoHelper::setSeoFields($this, $seo->translate($languageSlug));
        }

        public function deliveryZone(): HasMany
        {
            return $this->hasMany(DeliveryZone::class, 'ro_id', 'id');
        }

        public function workloads(): HasMany
        {
            return $this->hasMany(RetailObjectsRestaurantWorkload::class, 'ro_id', 'id');
        }

        public function updatedPosition($request)
        {
            if (!$request->has('position') || is_null($request->position) || $request->position == $this->position) {
                return $this->position;
            }

            $models = self::orderBy('position', 'desc')->get();

            if ($models->count() == 1) {
                return 1;
            }

            $maxPosition = $models->first()->position;
            $minPosition = $models->last()->position;
            $newPosition = max(min($request['position'], $maxPosition), $minPosition);

            DB::transaction(function () use ($newPosition) {
                if ($newPosition > $this->position) {
                    self::where('id', '<>', $this->id)
                        ->whereBetween('position', [$this->position + 1, $newPosition])
                        ->decrement('position');
                } else {
                    self::where('id', '<>', $this->id)
                        ->whereBetween('position', [$newPosition, $this->position - 1])
                        ->increment('position');
                }

                $this->update(['position' => $newPosition]);
            });

            return $newPosition;
        }

        public function isPointInPolygon($point, $polygonJSON): bool
        {
            $polygon = json_decode($polygonJSON, true);
            $c = 0;
            $p1 = $polygon[0];
            $n = count($polygon);

            for ($i = 1; $i <= $n; $i++) {
                $p2 = $polygon[$i % $n];
                if ($point['lng'] > min($p1['lng'], $p2['lng'])
                    && $point['lng'] <= max($p1['lng'], $p2['lng'])
                    && $point['lat'] <= max($p1['lat'], $p2['lat'])
                    && $p1['lng'] != $p2['lng']) {
                    $xinters = ($point['lng'] - $p1['lng']) * ($p2['lat'] - $p1['lat']) / ($p2['lng'] - $p1['lng']) + $p1['lat'];
                    if ($p1['lat'] == $p2['lat'] || $point['lat'] <= $xinters) {
                        $c++;
                    }
                }
                $p1 = $p2;
            }

            return $c % 2 != 0;
        }
    }
