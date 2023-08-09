<?php

    namespace Modules\RetailObjectsRestourant\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;
    use Modules\RetailObjectsRestourant\Models\RetailObjectsRestaurantWorkload;

    class RestaurantPriorityUpdateRequest extends FormRequest
    {
        public const WITHOUT_PRIORITY = 9999;
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return true; // Update this if you have any authorization logic
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            return [
                'workload_priority_status' => [
                    'required',
                    Rule::in([
                                 RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_WEAK,
                                 RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_MODERATELY,
                                 RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_STRONG,
                                 RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_VERY_STRONG,
                                 RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_CLOSED,
                                 RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_ORDERS_STOPPED,
                                 self::WITHOUT_PRIORITY
                             ]),
                ],
            ];
        }

        /**
         * Get the error messages for the defined validation rules.
         *
         * @return array
         */
        public function messages(): array
        {
            return [
                'workload_priority_status.required' => '.',
                'workload_priority_status.in'       => 'The workload priority status must be a valid status.',
            ];
        }
    }
