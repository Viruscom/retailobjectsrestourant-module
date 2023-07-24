<?php

namespace Modules\RetailObjectsRestourant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetailObjectsRestaurantSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
