<?php

namespace App;

use Carbon\Carbon;

class Period
{
    /**
     * Period constructor.
     * @param Carbon $start
     * @param Carbon $end
     */
    public function __construct(Carbon $start, Carbon $end)
    {

    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return int
     */
    public function days(Carbon $start, Carbon $end): int
    {
        return $start->copy()->diffInDays($end->copy()) + 1;
    }
}