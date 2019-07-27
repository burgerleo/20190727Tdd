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
        $expected = 100;
        $start = new \DateTime('20190201');
        $end = new \DateTime('20190201');
        $this->giveGetAll();
        $result = $this->budgetService->query($start, $end);
        $this->assertEquals($expected, $result);
    }

    private function giveGetAll()
    {
        $datebudget = [
            '201901' => 3100,
            '201902' => 2800,
        ];

        $this->mockBudgetRepository->shouldReceive('getAll')->andReturn($datebudget);
    }
}
