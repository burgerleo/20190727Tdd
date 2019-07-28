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
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return int
     */
    public function days(Carbon $start, Carbon $end): int
    {
        return $this->start->diffInDays($this->end) + 1;
    }



}