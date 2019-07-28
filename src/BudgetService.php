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
        $budgets = $this->budgetRepository->getAll();

        if (count($budgets) == 0) {
            return 0;
        }

        $period = new Period($start, $end);

        return $period->days($start, $end);

    }
}
