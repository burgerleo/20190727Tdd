<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests;

use App\BudgetService;
use App\Module\Budget;
use App\Repositories\BudgetRepository;
use Carbon\Carbon;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class BudgetServiceTest extends TestCase
{
    protected $stubRepository;
    protected $budgetService;

    protected function setUp()
    {
        $this->stubRepository = m::spy(BudgetRepository::class);

        $this->budgetService = new BudgetService($this->stubRepository);
    }

    public function test_query_No_OverLap()
    {
        $budgetAmount = 0;
        $this->giveStartDateAndEndDate('20190301', '20190303');
        $this->budgetShouldBe($budgetAmount);
    }

    public function test_period_inside_budget_month()
    {
        $budgetAmount = 1;
        $this->giveStartDateAndEndDate('20190402', '20190402');
        $this->givenBudgets(array(new Budget('201004', 30)));
        $this->budgetShouldBe($budgetAmount);
    }

    private function giveStartDateAndEndDate(string $start, string $end)
    {
        $this->start = new Carbon($start);
        $this->end = new Carbon($end);
    }

    private function budgetShouldBe(int $budgetAmount)
    {
        $this->assertEquals($budgetAmount, $this->budgetService->query($this->start, $this->end));
    }

    private function givenBudgets($budgets): void
    {
        $this->stubRepository->shouldReceive('getAll')->andReturn($budgets);
    }

}
