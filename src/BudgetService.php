<?php

namespace App;

use App\Repositories\BudgetRepository;
use Carbon\Carbon;

class BudgetService
{
    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function query(Carbon $startDate, Carbon $endDate)
    {
        // 起晚於訖
        if ($startDate->format('Ymd') > $endDate->format('Ymd')) {
            return 0;
        }

        if ($startDate->format('Ym') === $endDate->format('Ym')) {

            return $this->budgetRepository->getMonthValidBugdget($startDate, ($endDate->day - $startDate->day + 1));
        }

        $budget = $this->getDiffMonthBudget($startDate, $endDate);

        return $budget;
    }

    private function getStartDateValidBudget(Carbon $startDate): int
    {
        return $this->budgetRepository->getMonthValidBugdget($startDate, $startDate->daysInMonth - $startDate->day + 1);
    }

    private function getEndDateValidBudget(Carbon $endDate): int
    {
        return $this->budgetRepository->getMonthValidBugdget($endDate, $endDate->day);
    }

    private function getDiffMonthBudget(Carbon $startDate, Carbon $endDate): int
    {
        $budget = 0;

        $months = $startDate->copy()->startOfMonth()->diffInMonths($endDate->copy()->endOfMonth()) + 1;

        for ($i = 0; $i <= $months; $i++) {
            $midMonth = $startDate->copy()->startOfMonth()->addMonth($i);

            if ($startDate->format('Ym') == $midMonth->format('Ym')) {
                $budget += $this->getStartDateValidBudget($startDate);
            } else if ($endDate->format('Ym') == $midMonth->format('Ym')) {
                $budget += $this->getEndDateValidBudget($endDate);
            } else {
                $budget += $this->budgetRepository->getMonthValidBugdget($midMonth, $midMonth->daysInMonth);
            }
        }

        return $budget;
    }
}
