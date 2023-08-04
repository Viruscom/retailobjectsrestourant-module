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
use Illuminate\Support\Facades\Cache;
use Modules\RetailObjectsRestourant\Http\Requests\ProductAdditiveStoreRequest;
use Modules\RetailObjectsRestourant\Http\Requests\ProductAdditiveUpdateRequest;
use Modules\RetailObjectsRestourant\Models\ProductAdditive;
use Modules\RetailObjectsRestourant\Models\ProductAdditiveTranslation;

class ProductAdditivesController extends Controller
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES))) {
            ProductAdditive::cacheUpdate();
        }

        return view('retailobjectsrestourant::admin.product_additives.index', ['characteristics' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES)]);
    }
    public function store(ProductAdditiveStoreRequest $request, CommonControllerAction $action)
    {
        $productAdditive = $action->doSimpleCreate(ProductAdditive::class, $request);
        ProductAdditive::cacheUpdate();
        $productAdditive->storeAndAddNew($request);

        return redirect()->route('admin.product.additives.index')->with('success-message', trans('admin.common.successful_create'));
    }
    public function edit($id)
    {
        $productAdditive = ProductAdditive::where('id', $id)->with('translations')->first();
        WebsiteHelper::redirectBackIfNull($productAdditive);

        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES))) {
            ProductAdditive::cacheUpdate();
        }

        return view('retailobjectsrestourant::admin.product_additives.edit', [
            'productCharacteristic' => $productAdditive,
            'languages'             => LanguageHelper::getActiveLanguages(),
        ]);
    }
    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $ids = array_map('intval', explode(',', $request->ids[0]));
            foreach ($ids as $id) {
                $model = ProductAdditive::find($id);
                if (is_null($model)) {
                    continue;
                }

                $model->delete();
            }

            ProductAdditive::cacheUpdate();

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }
    public function delete($id, CommonControllerAction $action): RedirectResponse
    {
        $productAdditive = ProductAdditive::where('id', $id)->first();
        MainHelper::goBackIfNull($productAdditive);

        $productAdditive->delete();
        ProductAdditive::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function update($id, ProductAdditiveUpdateRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $productAdditive = ProductAdditive::find($id);
        if (is_null($productAdditive)) {
            return redirect()->back()->withInput()->withErrors(['admin.common.record_not_found']);
        }

        $action->doSimpleUpdate(ProductAdditive::class, ProductAdditiveTranslation::class, $productAdditive, $request);
        ProductAdditive::cacheUpdate();

        return redirect()->route('admin.product.additives.index')->with('success-message', 'admin.common.successful_edit');
    }
    public function create()
    {
        return view('retailobjectsrestourant::admin.product_additives.create', [
            'languages' => LanguageHelper::getActiveLanguages()
        ]);
    }
}
