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

    public function test_Period_Inside_Budget_Month()
    {
        $budgetAmount = 1;
        $this->giveStartDateAndEndDate('20190401', '20190401');
        $this->givenBudgets(array(new Budget('201904', 30)));
        $this->budgetShouldBe($budgetAmount);
    }

    public function test_Period_No_Overlap_Before_Budget_First_Month()
    {
        $budgetAmount = 0;
        $this->giveStartDateAndEndDate('20190330', '20190331');
        $this->givenBudgets(array(new Budget('201904', 30)));
        $this->budgetShouldBe($budgetAmount);
    }

    public function test_Period_No_Overlap_Before_Budget_Last_Month()
    {
        $budgetAmount = 0;
        $this->giveStartDateAndEndDate('20190501', '20190502');
        $this->givenBudgets(array(new Budget('201904', 30)));
        $this->budgetShouldBe($budgetAmount);
    }

    public function test_Period_Overlap_Budget_First_Day()
    {
        $budgetAmount = 1;
        $this->giveStartDateAndEndDate('20190331', '20190401');
        $this->givenBudgets(array(new Budget('201904', 30)));
        $this->budgetShouldBe($budgetAmount);
    }

    public function test_Period_Overlap_Budget_Last_Day()
    {
        $budgetAmount = 1;
        $this->giveStartDateAndEndDate('20190430', '20190501');
        $this->givenBudgets(array(new Budget('201904', 30)));
        $this->budgetShouldBe($budgetAmount);
    }

    public function test_Period_Cross_Budget_Month()
    {
        $budgetAmount = 30;
        $this->giveStartDateAndEndDate('20190331', '20190501');
        $this->givenBudgets(array(new Budget('201904', 30)));
        $this->budgetShouldBe($budgetAmount);
    }

    public function test_Daily_Amount_Is_10_Money()
    {
        $budgetAmount = 30;
        $this->giveStartDateAndEndDate('20190403', '20190405');
        $this->givenBudgets(array(new Budget('201904', 300)));
        $this->budgetShouldBe($budgetAmount);
    }

    public function test_Sum_Cross_Budget_Month()
    {
        $budgetAmount = 231;
        $this->giveStartDateAndEndDate('20190331', '20190501');
        $this->givenBudgets([
            (new Budget('201903', 31)),
            (new Budget('201904', 30)),
            (new Budget('201905', 6200)),
        ]);
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
