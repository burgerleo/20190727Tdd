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

        if ($startData->format('Ymd') === $endData->format('Ymd')) {

            return $budgetRepository[$startData->format('Ym')]/$startData->format('t');
        }


        return $budgetRepository;
    }
}
