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
     * @param Period $another
     * @return int
     */
    public function overlappingDays(Period $another)
    {
        if ($this->hasNoOverlapping($another) || $this->invalidPeriod()) {
            return 0;
        }

        $effectiveStart = ($another->start > $this->start) ?
            $another->start :
            $this->start;

        $effectiveEnd = ($another->end < $this->end) ?
            $another->end :
            $this->end;

        return $effectiveStart->diffInDays($effectiveEnd) + 1;
    }

    /**
     * @param Period $another
     * @return bool
     */
    private function hasNoOverlapping(Period $another)
    {
        return $this->start > $another->end || $this->end < $another->start;
    }

    /**
     * @return bool
     */
    private function invalidPeriod()
    {
        return $this->end < $this->start;
    }
}
