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
        $budgetRepository = $this->budgetRepository->getAll();

        // 起晚於訖
        if($startData->format('Ymd') > $endData->format('Ymd')){
            return 0;
        }



        if ($startData->format('Ym') === $endData->format('Ym')) {
            return $budgetRepository[$startData->format('Ym')]  / $startData->format('t') * ($endData->format('d') - $startData->format('d') + 1);
        }

        if ($startData->format('Ymd') === $endData->format('Ymd')) {

            return $budgetRepository[$startData->format('Ym')] / $startData->format('t');
        }




        return $budgetRepository;
    }
}
