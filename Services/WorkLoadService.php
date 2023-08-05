<?php

namespace Modules\RetailObjectsRestourant\Services;

use Carbon\Carbon;

class WorkLoadService
{
    /**
     * Връща текущия ден от седмицата, като понеделник е 0.
     *
     * @return int Денят от седмицата, където 0 е понеделник, 1 е вторник, ..., 6 е неделя
     */
    public function getDayOfWeek(): int
    {
        return Carbon::now()->dayOfWeek;
    }

    public function getCurrentWorkloadStatus($restaurant)
    {

    }
}
