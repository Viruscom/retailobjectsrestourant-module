<?php

namespace Modules\RetailObjectsRestourant\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\RetailObjectsRestourant\Models\RetailObjectsRestaurantSettings;

class RetailObjectsRestaurantSettingsController extends Controller
{
    public function index()
    {
        return view('retailobjectsrestourant::admin.settings.index', ['settings' => RetailObjectsRestaurantSettings::all()]);
    }

    public function update(Request $request)
    {
        foreach ($request->setting as $key => $value) {
            $settingToUpdate = RetailObjectsRestaurantSettings::where('key', $key)->first();
            if (!is_null($settingToUpdate)) {
                $settingToUpdate->update(['key' => $key, 'value' => $value]);
            }
        }

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
}
