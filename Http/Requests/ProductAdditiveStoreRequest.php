<?php

namespace Modules\RetailObjectsRestourant\Http\Requests;

use App\Helpers\LanguageHelper;
use Illuminate\Foundation\Http\FormRequest;

class ProductAdditiveStoreRequest extends FormRequest
{
    protected $LANGUAGES;

    public function __construct()
    {
        $this->LANGUAGES = LanguageHelper::getActiveLanguages();
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $this->trimInput();
        foreach ($this->LANGUAGES as $language) {
            $array['title_' . $language->code] = 'required';
        }

        $array['price'] = ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'];

        return $array;
    }
    public function trimInput(): void
    {
        $trim_if_string = static function ($var) {
            return is_string($var) ? trim($var) : $var;
        };
        $this->merge(array_map($trim_if_string, $this->all()));
    }
    public function messages(): array
    {
        foreach ($this->LANGUAGES as $language) {
            $messages['title_' . $language->code . '.required'] = 'Полето за заглавие (' . $language->code . ') е задължително';
        }

        $messages['price.required'] = 'Полето за цена е задължително.';
        $messages['price.numeric']  = 'Полето за цена трябва да бъде числово.';
        $messages['price.regex']    = 'Полето за цена трябва да бъде валидна цена от типа 0,00.';

        return $messages;
    }
    protected function prepareForValidation()
    {
        $this->merge([
                         'price' => str_replace(',', '.', $this->price),
                     ]);
    }
}
