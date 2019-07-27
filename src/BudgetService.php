<?php

namespace App;

use App\Repositories\BudgetRepository;

class BudgetService
{
    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function query($startData, $endData)
    {
        // 起晚於訖
        if($startData->format('Ymd') > $endData->format('Ymd')){
            return 0;
        }

        if ($startData->format('Ym') === $endData->format('Ym')) {
            $days = $endData->format('d') - $startData->format('d') + 1;

            return $this->getDailyBudget($startData) * $days;
        }

        return '沒做拉';
    }

    public function getMonth($date): int
    {
        $budgetRepository = $this->budgetRepository->getAll();

        return isset($budgetRepository[$date->format('Ym')])?$budgetRepository[$date->format('Ym')]:0;
    }

    /**
     * @param $startData
     * @return float|int
     */
    private function getDailyBudget($startData)
    {
        return $this->getMonth($startData) / $startData->format('t');
    }
}
