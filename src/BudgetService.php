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

    public function query(Carbon $startData, Carbon $endData)
    {
        return 0;
    }
}
