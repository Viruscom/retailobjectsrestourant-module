<?php

namespace Modules\RetailObjectsRestourant\Http\Controllers\Admin\ProductAdditives;

use App\Actions\CommonControllerAction;
use App\Helpers\CacheKeysHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Modules\RetailObjectsRestourant\Models\ProductAdditive;
use Modules\Shop\Http\Requests\ProductCharacteristicRequest;
use Modules\Shop\Models\Admin\ProductCategory\Category;
use Modules\Shop\Models\Admin\Products\ProductCharacteristicPivot;
use Modules\Shop\Models\Admin\Products\ProductCharacteristicTranslation;

class ProductAdditivesController extends Controller
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES))) {
            ProductAdditive::cacheUpdate();
        }

        return view('retailobjectsrestourant::admin.product_additives.index', ['characteristics' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES)]);
    }
    public function store(ProductCharacteristicRequest $request, CommonControllerAction $action)
    {
        $productAdditive = $action->doSimpleCreate(ProductAdditive::class, $request);
        ProductAdditive::cacheUpdate();
        $productAdditive->storeAndAddNew($request);

        return redirect()->route('admin.products.characteristics.index')->with('success-message', trans('admin.common.successful_create'));
    }
    public function edit($id)
    {
        $productAdditive = ProductAdditive::where('id', $id)->with('translations')->first();
        WebsiteHelper::redirectBackIfNull($productAdditive);

        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES))) {
            ProductAdditive::cacheUpdate();
        }

        return view('shop::admin.products.characteristics.edit', [
            'productCharacteristic'     => $productAdditive,
            'languages'                 => LanguageHelper::getActiveLanguages(),
            'characteristics'           => Cache::get('adminProductCharacteristics'),
            'productCategories'         => Category::with('translations')->get(),
            'selectedProductCategories' => Arr::flatten(ProductCharacteristicPivot::select('product_category_id')->where('product_characteristic_id', $productAdditive->id)->get()->toArray())
        ]);
    }
    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $action->deleteMultiple($request, ProductAdditive::class);

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }
    public function update($id, ProductCharacteristicRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $productAdditive = ProductAdditive::find($id);
        if (is_null($productAdditive)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        //        $request['position'] = $productAdditive->updatedPosition($request);
        $action->doSimpleUpdate(ProductAdditive::class, ProductCharacteristicTranslation::class, $productAdditive, $request);

        if ($request->has('productCategories')) {
            ProductCharacteristicPivot::where('product_characteristic_id', $productAdditive->id)->delete();
            foreach ($request->productCategories as $key => $productCategoryId) {
                ProductCharacteristicPivot::create([
                                                       'product_characteristic_id' => $productAdditive->id,
                                                       'product_category_id'       => $productCategoryId
                                                   ]);
            }
        }

        ProductAdditive::cacheUpdate();

        return redirect()->route('admin.products.characteristics.index')->with('success-message', 'admin.common.successful_edit');
    }
    public function delete($id, CommonControllerAction $action): RedirectResponse
    {
        $productAdditive = ProductAdditive::where('id', $id)->first();
        MainHelper::goBackIfNull($productAdditive);

        $action->delete(ProductAdditive::class, $productAdditive);

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function create()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES))) {
            ProductAdditive::cacheUpdate();
        }
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN))) {
            Category::cacheUpdate();
        }

        return view('shop::admin.products.characteristics.create', [
            'languages'         => LanguageHelper::getActiveLanguages(),
            'characteristics'   => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES),
            'productCategories' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN)
        ]);
    }
}
