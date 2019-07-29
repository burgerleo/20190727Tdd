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

    /**
     * @param Budget $budget
     * @return int
     */
    public function overlappingDays(Budget $budget)
    {
        if ($this->start > $budget->getLastDay() || $this->end < $budget->getFirstDay()) {
            return 0;
        }

        $effectiveStart = ($budget->getFirstDay() > $this->start) ?
        $budget->getFirstDay() :
        $this->start;

        $effectiveEnd = ($budget->getLastDay() < $this->end) ?
        $budget->getLastDay() :
        $this->end;

        return $effectiveStart->diffInDays($effectiveEnd) + 1;
    }

}
