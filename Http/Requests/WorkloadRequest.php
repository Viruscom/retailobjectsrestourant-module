<?php

    namespace Modules\RetailObjectsRestourant\Http\Requests;

    use Carbon\Carbon;
    use Illuminate\Foundation\Http\FormRequest;

    class WorkloadRequest extends FormRequest
    {
        public function authorize()
        {
            return true;
        }
        public function rules()
        {
            $rules = [];

            $rules['workload.*.*'] = [
                function ($attribute, $value, $fail) {
                    $formTime = Carbon::createFromFormat('H:i', $value['form_time']);
                    $toTime   = Carbon::createFromFormat('H:i', $value['to_time']);

                    $parts            = explode('.', $attribute);
                    $currentDayOfWeek = $parts[2];

                    foreach ($this->input('workload') as $status => $days) {
                        foreach ($days as $dayOfWeek => $times) {
                            if ($attribute === "workload.$status.$dayOfWeek" || $dayOfWeek != $currentDayOfWeek) continue;

                            $otherFormTime = Carbon::createFromFormat('H:i', $times['form_time']);
                            $otherToTime   = Carbon::createFromFormat('H:i', $times['to_time']);

                            $dayName = Carbon::now()->startOfWeek()->addDays($dayOfWeek)->locale(config('default.app.language.code'))->dayName;

                            if (($formTime->between($otherFormTime, $otherToTime) && !$formTime->eq($otherToTime)) || ($toTime->between($otherFormTime, $otherToTime) && !$toTime->eq($otherFormTime))) {
                                $fail("Времената се презастъпват с друг статус за същия ден. Конфликт между {$formTime->format('H:i')} - {$toTime->format('H:i')} и {$otherFormTime->format('H:i')} - {$otherToTime->format('H:i')} за ден {$dayName}.");
                            }
                        }
                    }
                },
            ];

            return $rules;
        }

        public function withValidator($validator)
        {
            $validator->after(function ($validator) {
                $workloadData = $this->input('workload');

                foreach ($workloadData as $status => $days) {
                    foreach ($days as $dayOfWeek => $intervals) {
                        $previousToTime = null;
                        $fromTime       = $intervals["form_time"];
                        $toTime         = $intervals["to_time"];
                        if ($previousToTime && $fromTime < $previousToTime) {
                            $validator->errors()->add("workload.$status.$dayOfWeek", 'Презастъпване на времеви интервали.');
                        }

                        $previousToTime = $toTime;
                    }
                }
            });
        }
        protected function prepareForValidation()
        {
            $workloadData = $this->input('workload');

            foreach ($workloadData as $status => $days) {
                foreach ($days as $dayOfWeek => $times) {
                    if (strlen($times['form_time']) != 5) {
                        $workloadData[$status][$dayOfWeek]['form_time'] = Carbon::createFromFormat('H:i:s', $times['form_time'])->format('H:i');
                    }
                    if (strlen($times['to_time']) != 5) {
                        $workloadData[$status][$dayOfWeek]['to_time'] = Carbon::createFromFormat('H:i:s', $times['to_time'])->format('H:i');
                    }
                }
            }

            $this->merge(['workload' => $workloadData]);
        }
    }
