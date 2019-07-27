<?php

namespace App;

use App\Repositories\BudgetRepository;
use DateTime;

class BudgetService
{
    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function query($startDate, $endDate)
    {
        // 起晚於訖
        if ($startDate->format('Ymd') > $endDate->format('Ymd')) {
            return 0;
        }

        $diffMonths = 0;
        
        // 如果年月相同可忽落此計算
        // 開頭月有效Budget + 結尾月有效Budget
        $budget = $this->getStartDateValidBudget($startDate) + $this->getEndDateValidBudget($endDate);

        if ($startDate->format('Y') === $endDate->format('Y')) {
            if ($startDate->format('Ym') === $endDate->format('Ym')) {

                //計算同年內差幾個月
                $days = $endDate->format('d') - $startDate->format('d') + 1;

                return $this->getMonthValidBugdget($startDate, $days);
            } else {
                //計算同年內差幾個月
                $diffMonths += $endDate->format('m') - $startDate->format('m') - 1;
            }
        } else {
            //計算差幾年共幾個月
            $diffMonths += ($endDate->format('Y') - $startDate->format('Y') - 1) * 12;

            // 計算離年底還有幾個月
            $diffMonths += (12 - $startDate->format('m'));

            // 計算離年初還有幾個月
            $diffMonths += ($endDate->format('m') - 1);
        }

        $budget += $this->getDiffMonthBudget($startDate, $diffMonths);

        return $budget;
    }

    private function getMonth(DateTime $date): int
    {
        $budgetRepository = $this->budgetRepository->getAll();

        return isset($budgetRepository[$date->format('Ym')]) ? $budgetRepository[$date->format('Ym')] : 0;
    }

    /**
     * @param $startDate
     * @return float|int
     */
    private function getDailyBudget(DateTime $date): int
    {
        return floor($this->getMonth($date) / $date->format('t'));
    }

    private function getMonthValidBugdget(DateTime $date, int $days): int
    {
        return $this->getDailyBudget($date) * $days;
    }

    private function getStartDateValidBudget(DateTime $startDate): int
    {
        $diffStartdays = $startDate->format('t') - $startDate->format('d') + 1;

        return $this->getMonthValidBugdget($startDate, $diffStartdays);
    }

    private function getEndDateValidBudget(DateTime $endDate): int
    {
        $diffEndDays = $endDate->format('d');

        return $this->getMonthValidBugdget($endDate, $diffEndDays);
    }

    private function getDiffMonthBudget(DateTime $startDate, int $months): int
    {
        $budget = 0;

        $startMonth = new DateTime($startDate->format('Ym') . '01');

        for ($i = 1; $i <= $months; $i++) {
            $end = $startMonth->modify("+$i month");

            $budget += $this->getMonth($end);
        }

        return $budget;
    }
}
