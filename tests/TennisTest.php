<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests ;

use App\Tennis;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;

class TennisTest extends TestCase
{
    protected $temmis;
    protected $palyer1 = 'Tone';
    protected $palyer2 = 'Joe';

    protected function setUp()
    {
        $this->temmis = new Tennis($this->palyer1, $this->palyer2);
    }

    public function test_Love_All()
    {
        $expected = 'Love All';
        $score = $this->temmis->score();
        $this->assertEquals($expected, $score);
    }

    public function test_Fiten_All()
    {
        $expected = 'Fiten All';
        $score = $this->temmis->score();
        $this->assertEquals($expected, $score);
    }
}

