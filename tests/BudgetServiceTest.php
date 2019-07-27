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
    protected $mockBudgetRepository;
    protected $budgetService;

    protected function setUp()
    {
        $this->mockBudgetRepository = m::mock(BudgetRepository::class);

        $this->budgetService = new BudgetService($this->mockBudgetRepository);

    }

    public function test_query_Single_Day()
    {
        $datebudget = [
            '201901' => 3100,
            '201902' => 2800,
        ];

        $expected = 100;
        $start = new DateTime('20190201');
        $end = new DateTime('20190201');
        $this->giveGetAll($datebudget);
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function query_start_after_end()
    {
        $datebudget = [
            '201901' => 3100,
            '201902' => 2800,
        ];

        $expected = 0;
        $end = new DateTime('20190101');
        $start = new DateTime('20190201');
        $this->giveGetAll($datebudget);
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function test_query_single_whole_month()
    {
        $dateBudget = [
            '201901' => 3100,
        ];

        $expected = 3100;
        $start = new DateTime('20190101');
        $end = new DateTime('20190131');

        $this->giveGetAll($dateBudget);
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function test_query_partial_month()
    {
        $dateBudget = [
            '201901' => 3100,
        ];

        $expected = 1000;
        $start = new DateTime('20190101');
        $end = new DateTime('20190110');

        $this->giveGetAll($dateBudget);
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function test_query_cross_months()
    {
        $dateBudget = [
            '202002' => 2900,
            '202003' => 3100,
        ];

        $expected = 1000;

        $start = new DateTime('20200221');
        $end = new DateTime('20200301');

        $this->giveGetAll($dateBudget);
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function test_query_cross_two_months()
    {
        $dateBudget = [
            '201901' => 3100,
            '201902' => 2800,
            '201903' => 3100,
        ];

        $expected = 3500;

        $start = new DateTime('20190130');
        $end = new DateTime('20190305');

        $this->giveGetAll($dateBudget);
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function query_cross_year()
    {
        $dateBudget = [
            '201812' => 3100,
            '201901' => 3100,
            '201902' => 2800,
        ];

        $expected = 3300;

        $start = new DateTime('20181231');
        $end = new DateTime('20190201');

        $this->giveGetAll($dateBudget);
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function query_cross_2year()
    {
        $dateBudget = [
            '201812' => 3100,
            '201901' => 3100,
            '202001' => 3100,
        ];

        $expected = 3300;

        $start = new DateTime('20181231');
        $end = new DateTime('20200101');

        $this->giveGetAll($dateBudget);
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }

    private function giveGetAll($datebudget)
    {
        $this->mockBudgetRepository->shouldReceive('getAll')->andReturn($datebudget);
    }
}
