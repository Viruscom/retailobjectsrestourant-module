<?php

    namespace Modules\RetailObjectsRestourant\Services;

    use Carbon\Carbon;
    use Modules\RetailObjectsRestourant\Models\RetailObjectsRestaurantWorkload;

    class WorkLoadService
    {
        public static function getCurrentWorkloadStatus(): string
        {
            if (session()->get('delivery_restaurant') == null) {
                return collect(['status' => 'error', 'workLoadStatus' => RetailObjectsRestaurantWorkload::frontStatusMapping(RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_VERY_STRONG)]);
            }

            $time        = Carbon::now()->locale(config('default.app.language.code'));
            $currentTime = $time->format('H:i:s');

            $restaurant = session()->get('delivery_restaurant');
            $workload   = $restaurant->workloads()
                ->where('day_of_week', $time->dayOfWeek)
                ->where('from_hour', '<=', $currentTime)
                ->where('to_hour', '>=', $currentTime)
                ->first();

            if (is_null($workload)) {
                return collect(['status' => 'error', 'workLoadStatus' => RetailObjectsRestaurantWorkload::frontStatusMapping(RetailObjectsRestaurantWorkload::WORKLOAD_STATUS_CLOSED)]);
            }

            if ($workload->has_extraordinary_status) {
                $workloadStatus = $workload->extraordinary_status;
            } else {
                $workloadStatus = $workload->workload_status;
            }

            return collect(['status' => 'success', 'workload' => $workload, 'workLoadStatus' => RetailObjectsRestaurantWorkload::frontStatusMapping($workloadStatus)]);
        }
        /**
         * Връща текущия ден от седмицата, като понеделник е 0.
         *
         * @return int Денят от седмицата, където 0 е понеделник, 1 е вторник, ..., 6 е неделя
         */
        public function getDayOfWeek(): int
        {
            return Carbon::now()->dayOfWeek;
        }
    }
