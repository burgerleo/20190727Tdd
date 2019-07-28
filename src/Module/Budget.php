<?php

namespace App\Module;

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
     * @param string $yearMonth
     * @param int $amount
     */
    public function __construct(string $yearMonth, int $amount)
    {
        $this->yearMonth = new Carbon($yearMonth . '01');
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getYearMonth():string
    {
        return $this->yearMonth;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getFirstDay(): Carbon
    {
        return $this->yearMonth->copy()->startOfDay();
    }

    /**
     * @return mixed
     */
    public function getLastDay(): Carbon
    {
        return $this->yearMonth->copy()->endOfDay();
    }
}
