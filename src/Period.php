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
    public function days(): int
    {
        return $this->start->diffInDays($this->end) + 1;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function overlapDays($budget)
    {
        if($this->start > $budget->getLastDay()){
            return 0;
        }

        if ($this->end < $budget->getFirstDay()) {
            return 0;
        }

        $effectiveStart = $this->start;

        if ($budget->getFirstDay() > $this->start) {
            $effectiveStart = $budget->getFirstDay();
        }

        return $effectiveStart->diffInDays($this->end) + 1;
    }

}