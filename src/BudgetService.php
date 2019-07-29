<?php

namespace App;

use App\Repositories\BudgetRepository;
use Carbon\Carbon;

class BudgetService
{
    protected $budgetRepository;

    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function query(Carbon $start, Carbon $end)
    {
        $period = new Period($start, $end);

        $totalBudget = 0;

        foreach ($this->budgetRepository->getAll() as $budget) {
            $totalBudget += $budget->getEffectiveDailyAmount($period);
        }

        return $totalBudget;

    }
}
