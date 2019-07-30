<?php

namespace App\Module;

use App\Period;
use Carbon\Carbon;

class Budget
{
    /**
     * @var string
     */
    private $yearMonth;
    /**
     * @var int
     */
    private $amount;

    /**
     * Budget constructor.
     * @param Carbon $yearMonth
     * @param int $amount
     */
    public function __construct(Carbon $yearMonth, int $amount = 0)
    {
        $this->yearMonth = $yearMonth;
        $this->amount = $amount;
    }

    /**
     * @param Period $period
     * @return float|int
     */
    public function getEffectiveAmount(Period $period)
    {
        return $period->overlappingDays($this->createPeriod()) * $this->getDailyAmount();
    }

    /**
     * @return Period
     */
    private function createPeriod(): Period
    {
        return new Period($this->getFirstDay(), $this->getLastDay());
    }

    /**
     * @return int
     */
    private function getDailyAmount(): int
    {
        return $this->amount / $this->getMonthDays();
    }

    /**
     * @return int
     */
    private function getMonthDays(): int
    {
        return $this->yearMonth->daysInMonth;
    }

    /**
     * @return Carbon
     */
    private function getFirstDay(): Carbon
    {
        return $this->yearMonth->copy()->startOfMonth();
    }

    /**
     * @return Carbon
     */
    private function getLastDay(): Carbon
    {
        return $this->yearMonth->copy()->endOfMonth();
    }
}
