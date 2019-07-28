<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests;

use App\BudgetService;
use App\Repositories\BudgetRepository;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class BudgetServiceTest extends TestCase
{
    protected $mockBudgetRepository;
    protected $budgetService;

    protected function setUp()
    {
        $this->mockBudgetRepository = m::spy(BudgetRepository::class);

        $this->budgetService = new BudgetService($this->mockBudgetRepository);
    }

    public function test_query_No_OverLap()
    {
        $budgetAmount = 0;
        $this->giveStartDateAndEndDate('20190301', '20190303');
        $this->budgetShouldBe($budgetAmount);
    }

    public function test_query_OverLap_One_Day()
    {
        $budgetAmount = 1;
        $this->giveStartDateAndEndDate('20190402', '20190402');
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


}
