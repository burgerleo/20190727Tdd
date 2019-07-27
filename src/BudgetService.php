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

    public function query($startData, $endData)
    {
        // 起晚於訖
        if ($startData->format('Ymd') > $endData->format('Ymd')) {
            return 0;
        }

        $budget = $this->getStartDateValidBudget($startData)
         + $this->getMonthBugdget($endData, $endData->format('d'));

        if ($startData->format('Y') === $endData->format('Y')) {
            if ($startData->format('Ym') === $endData->format('Ym')) {
                $days = $endData->format('d') - $startData->format('d') + 1;

                return $this->getDailyBudget($startData) * $days;
            } else {

                $diffMonth = $endData->format('m') - $startData->format('m') - 1;

                for ($i = 0; $i < $diffMonth; $i++) {
                    $budget += $this->getMonth($startData->modify("-" . ($startData->format('d') - 1) . " days")->modify("+1 month"));
                }

                return $budget;

            }
        }
        //計算差幾年
        $diffYear = $endData->format('Y') - $startData->format('Y') - 1;

        for ($i = 1; $i <= $diffYear; $i++) {
            $yearMonth = $startData->format('Y') + $i;

            $year = new DateTime($yearMonth . '0101');

            $budget += $this->getYearBugdget($year);
        }

        $diffStartMonth = 12 - $startData->format('m');

        for ($i = 0; $i < $diffStartMonth; $i++) {
            $budget += $this->getMonth($startData->modify("-" . ($startData->format('d') - 1) . " days")->modify("+1 month"));
        }

        $diffEndMonth = $endData->format('m') - 1;

        for ($i = 0; $i < $diffEndMonth; $i++) {
            $budget += $this->getMonth($startData->modify("-" . ($startData->format('d') - 1) . " days")->modify("+1 month"));
        }

        return $budget;
    }

    private function getMonth(DateTime $date): int
    {
        $budgetRepository = $this->budgetRepository->getAll();

        return isset($budgetRepository[$date->format('Ym')]) ? $budgetRepository[$date->format('Ym')] : 0;
    }

    /**
     * @param $startData
     * @return float|int
     */
    private function getDailyBudget(DateTime $date)
    {
        return $this->getMonth($date) / $date->format('t');
    }

    private function getMonthBugdget(DateTime $date, int $days)
    {
        return $this->getDailyBudget($date) * $days;
    }

    private function getStartDateValidBudget(DateTime $startData)
    {
        $diffStartdays = $startData->format('t') - $startData->format('d') + 1;

        return $this->getMonthBugdget($startData, $diffStartdays);
    }

    private function getYearBugdget(DateTime $date)
    {
        $budget = 0;
        for ($x = 0; $x < 12; $x++) {
            $end = $date->modify("+$x month");
            $budget += $this->getMonth($end);
        }
        return $budget;
    }
}
