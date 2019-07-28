<?php

namespace App;

use App\Module\Budget;
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

    public function overlapDays(Budget $budget)
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

        $effectiveEnd = $this->end;
        if ($budget->getLastDay() < $this->end) {
            $effectiveEnd = $budget->getLastDay();
        }

        return $effectiveStart->diffInDays($effectiveEnd) + 1;
    }

}