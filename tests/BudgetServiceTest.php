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
        $start = new \DateTime('20190201');
        $end = new \DateTime('20190201');
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
        $end = new \DateTime('20190101');
        $start = new \DateTime('20190201');
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
        $start = new \DateTime('20190101');
        $end = new \DateTime('20190131');


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
        $start = new \DateTime('20190101');
        $end = new \DateTime('20190110');


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
            '201901' => 3100,
            '201902' => 2800,
        ];

        $expected = 700;

        $start = new \DateTime('20190130');
        $end = new \DateTime('20190205');

        $this->giveGetAll($dateBudget);
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }


    private function giveGetAll($datebudget)
    {
        $this->mockBudgetRepository->shouldReceive('getAll')->andReturn($datebudget);
    }
}
