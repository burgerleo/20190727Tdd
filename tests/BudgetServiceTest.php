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
use DateTime;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class BudgetServiceTest extends TestCase
{
    protected $mockBudgetRepository, $budgetService;
    private $start, $end, $totalBudget;

    protected function setUp()
    {
        $this->mockBudgetRepository = m::mock(BudgetRepository::class);

        $this->budgetService = new BudgetService($this->mockBudgetRepository);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->mockBudgetRepository = null;
        $this->budgetService = null;
        $this->start = null;
        $this->end = null;
        $this->totalBudget = null;
    }

    public function test_query_Single_Day()
    {
        $this->totalBudget = [
            '201901' => 3100,
            '201902' => 2800,
        ];

        $start = '20190201';
        $end = '20190201';

        $expectedBudget = 100;

        $this->giveStartDateAndEndDate($start, $end);
        $this->budgetShouldBe($expectedBudget);
    }

    /**
     * @test
     */
    public function query_start_after_end()
    {
        $this->totalBudget = [
            '201901' => 3100,
            '201902' => 2800,
        ];

        $start = '20190201';
        $end = '20190101';

        $expectedBudget = 0;

        $this->giveStartDateAndEndDate($start, $end);
        $this->budgetShouldBe($expectedBudget);
    }

    /**
     * @test
     */
    public function test_query_single_whole_month()
    {
        $this->totalBudget = [
            '201901' => 3100,
        ];

        $start = '20190101';
        $end = '20190131';

        $expectedBudget = 3100;

        $this->giveStartDateAndEndDate($start, $end);
        $this->budgetShouldBe($expectedBudget);
    }

    /**
     * @test
     */
    public function test_query_partial_month()
    {
        $this->totalBudget = [
            '201901' => 3100,
        ];

        $start = '20190101';
        $end = '20190110';

        $expectedBudget = 1000;

        $this->giveStartDateAndEndDate($start, $end);
        $this->budgetShouldBe($expectedBudget);
    }

    /**
     * @test
     */
    public function test_query_cross_months()
    {
        $this->totalBudget = [
            '202002' => 2900,
            '202003' => 3100,
        ];

        $start = '20200221';
        $end = '20200301';

        $expectedBudget = 1000;

        $this->giveStartDateAndEndDate($start, $end);
        $this->budgetShouldBe($expectedBudget);
    }

    /**
     * @test
     */
    public function test_query_cross_two_months()
    {
        $this->totalBudget = [
            '201901' => 3100,
            '201902' => 2800,
            '201903' => 3100,
        ];

        $start = '20190130';
        $end = '20190305';

        $expectedBudget = 3500;

        $this->giveStartDateAndEndDate($start, $end);
        $this->budgetShouldBe($expectedBudget);
    }

    /**
     * @test
     */
    public function query_cross_year()
    {
        $this->totalBudget = [
            '201812' => 3100,
            '201901' => 3100,
            '201902' => 2800,
        ];

        $start = '20181231';
        $end = '20190201';

        $expectedBudget = 3300;

        $this->giveStartDateAndEndDate($start, $end);
        $this->budgetShouldBe($expectedBudget);
    }

    /**
     * @test
     */
    public function query_cross_2year()
    {
        $this->totalBudget = [
            '201812' => 3100,
            '201901' => 3100,
            '202001' => 3100,
        ];

        $start = '20181230';
        $end = '20200102';

        $expectedBudget = 3500;

        $this->giveStartDateAndEndDate($start, $end);
        $this->budgetShouldBe($expectedBudget);
    }

    private function giveGetAll()
    {
        $this->mockBudgetRepository->shouldReceive('getAll')->andReturn($this->totalBudget);
    }

    private function giveStartDateAndEndDate($start, $end)
    {
        $this->start = new DateTime($start);
        $this->end = new DateTime($end);
    }

    private function budgetShouldBe(string $expected)
    {
        $this->giveGetAll();

        $result = $this->budgetService->query($this->start, $this->end);
        $this->assertEquals($expected, $result);
    }

}
