<?php

namespace App\Repositories;

use Carbon\Carbon;

class BudgetRepository
{
    public $budgetAll = [];

    public function getAll()
    {
        return $this->budgetAll;
    }

    public function getMonthValidBugdget(Carbon $date, int $days): int
    {
        return $this->getDailyBudget($date) * $days;
    }

    /**
     * @param $startDate
     * @return float|int
     */
    public function getDailyBudget(Carbon $date): int
    {
        return floor($this->getMonth($date) / $date->daysInMonth);
    }

    public function getMonth(Carbon $date): int
    {
        return isset($this->budgetAll[$date->format('Ym')]) ?
        $this->budgetAll[$date->format('Ym')] :
        0;
    }

}
