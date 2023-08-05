<?php

namespace Modules\RetailObjectsRestourant\Http\Controllers;

use App\Actions\CommonControllerAction;
use App\Helpers\CacheKeysHelper;
use App\Helpers\FileDimensionHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\RetailObjects\Http\Requests\RetailObjectStoreRequest;
use Modules\RetailObjects\Http\Requests\RetailObjectsUpdateRequest;
use Modules\RetailObjectsRestourant\Models\RetailObjectsRestaurantSettings;
use Modules\RetailObjectsRestourant\Models\RetailObjectsRestourant;
use Modules\RetailObjectsRestourant\Models\RetailObjectsRestourantTranslation;

class RetailObjectsRestourantController extends Controller
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$RETAIL_OBJECT_RESTAURANT_ADMIN))) {
            RetailObjectsRestourant::cacheUpdate();
        }

        return view('retailobjectsrestourant::admin.restaurants.index', ['retailObjects' => Cache::get(CacheKeysHelper::$RETAIL_OBJECT_RESTAURANT_ADMIN)]);
    }
    public function store(RetailObjectStoreRequest $request, CommonControllerAction $action): RedirectResponse
    {
        if ($request->has('image')) {
            $request->validate(['image' => FileDimensionHelper::getRules('RetailObjectsRestourant', 1)], FileDimensionHelper::messages('RetailObjectsRestourant', 1));
        }
        $team = $action->doSimpleCreate(RetailObjectsRestourant::class, $request);
        $action->updateUrlCache($team, RetailObjectsRestourantTranslation::class);
        $action->storeSeo($request, $team, 'RetailObjects');
        RetailObjectsRestourant::cacheUpdate();

        $team->storeAndAddNew($request);

        return redirect()->route('admin.retail-objects-restaurants.index')->with('success-message', trans('admin.common.successful_create'));
    }
    public function edit($id)
    {
        $retailObject = RetailObjectsRestourant::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($retailObject);

        return view('retailobjectsrestourant::admin.restaurants.edit', [
            'retailObject'  => $retailObject,
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => RetailObjectsRestourant::getUserInfoMessage()
        ]);
    }
    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $action->deleteMultiple($request, RetailObjectsRestourant::class);

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }
    public function activeMultiple($active, Request $request, CommonControllerAction $action): RedirectResponse
    {
        $action->activeMultiple(RetailObjectsRestourant::class, $request, $active);
        RetailObjectsRestourant::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function active($id, $active): RedirectResponse
    {
        $retailObject = RetailObjectsRestourant::find($id);
        MainHelper::goBackIfNull($retailObject);

        $retailObject->update(['active' => $active]);
        RetailObjectsRestourant::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function update($id, RetailObjectsUpdateRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $retailObject = RetailObjectsRestourant::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($retailObject);

        $action->doSimpleUpdate(RetailObjectsRestourant::class, RetailObjectsRestourantTranslation::class, $retailObject, $request);
        $action->updateUrlCache($retailObject, RetailObjectsRestourantTranslation::class);
        $action->updateSeo($request, $retailObject, 'RetailObjects');

        if ($request->has('image')) {
            $request->validate(['image' => FileDimensionHelper::getRules('RetailObjectsRestourant', 1)], FileDimensionHelper::messages('RetailObjectsRestourant', 1));
            $retailObject->saveFile($request->image);
        }

        RetailObjectsRestourant::cacheUpdate();

        return redirect()->route('admin.retail-objects-restaurants.index')->with('success-message', 'admin.common.successful_edit');
    }
    public function positionUp($id, CommonControllerAction $action): RedirectResponse
    {
        $retailObject = RetailObjectsRestourant::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($retailObject);

        $action->positionUp(RetailObjectsRestourant::class, $retailObject);
        RetailObjectsRestourant::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function positionDown($id, CommonControllerAction $action): RedirectResponse
    {
        $retailObject = RetailObjectsRestourant::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($retailObject);

        $action->positionDown(RetailObjectsRestourant::class, $retailObject);
        RetailObjectsRestourant::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function deleteImage($id, CommonControllerAction $action): RedirectResponse
    {
        $retailObject = RetailObjectsRestourant::find($id);
        MainHelper::goBackIfNull($retailObject);

        if ($action->imageDelete($retailObject, RetailObjectsRestourant::class)) {
            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.image_not_found']);
    }
    public function storeDeliveryZone($id, Request $request)
    {
        $retailObject = RetailObjectsRestourant::find($id);
        if (is_null($retailObject)) {
            return response()->json(['error' => '1234']);
        }

        $deliveryZone = $retailObject->deliveryZone()->first();
        if (!is_null($deliveryZone)) {
            $deliveryZone->delete();
        }
        $retailObject->deliveryZone()->create(['polygon' => json_encode($request->polygon)]);

        return response()->json(['success' => true]);
    }
    public function deliveryZone($id)
    {
        $retailObject = RetailObjectsRestourant::where('id', $id)->with('deliveryZone')->first();
        MainHelper::goBackIfNull($retailObject);

        $GOOGLE_MAPS_API_KEY = RetailObjectsRestaurantSettings::where('key', 'google_maps_api_key')->first();
        if (is_null($GOOGLE_MAPS_API_KEY)) {
            return redirect()->back()->withErrors(['Google Maps Api Key не е въведен. Въведете го от Ресторант настройки, за да продължите.']);
        }

        return view('retailobjectsrestourant::admin.restaurants.delivery_zone', [
            'GOOGLE_MAPS_API_KEY' => $GOOGLE_MAPS_API_KEY->value,
            'retailObject'        => $retailObject,

        ]);
    }
    public function delete($id, CommonControllerAction $action): RedirectResponse
    {
        $retailObject = RetailObjectsRestourant::where('id', $id)->first();
        MainHelper::goBackIfNull($retailObject);

        $action->deleteFromUrlCache($retailObject);
        $action->delete(RetailObjectsRestourant::class, $retailObject);

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function create()
    {
        return view('retailobjectsrestourant::admin.restaurants.create', [
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => RetailObjectsRestourant::getUserInfoMessage()
        ]);
    }

    public function workload($id)
    {
        $retailObject = RetailObjectsRestourant::where('id', $id)->first();
        MainHelper::goBackIfNull($retailObject);

        return view('retailobjectsrestourant::admin.restaurants.workload', compact('retailObject'));
    }
}
