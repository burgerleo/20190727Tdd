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
    protected $palyer1 = 'Tom';
    protected $palyer2 = 'Joe';

    protected function setUp()
    {
        $this->temmis = new Tennis($this->palyer1, $this->palyer2);
    }

    public function test_Love_All()
    {
        $expected = 'Love All';
        $this->scoreShouldBe($expected);
    }

    public function test_Fiten_Love()
    {
        $this->giveFirstPlayerScoreTimes(1);

        $expected = 'Fiten Love';
        $this->scoreShouldBe($expected);
    }

    public function test_Thirty_Love()
    {
        $this->giveFirstPlayerScoreTimes(2);

        $expected = 'Thirty Love';
        $this->scoreShouldBe($expected);
    }

    public function test_Forty_Love()
    {
        $this->giveFirstPlayerScoreTimes(3);

        $expected = 'Forty Love';
        $this->scoreShouldBe($expected);
    }

    public function test_Love_Fiten()
    {
        $this->giveSecondPlayerScoreTimes(1);

        $expected = 'Love Fiten';
        $this->scoreShouldBe($expected);
    }

    public function test_Love_Thirty()
    {
        $this->giveSecondPlayerScoreTimes(2);

        $expected = 'Love Thirty';
        $this->scoreShouldBe($expected);
    }

    public function test_Love_Forty()
    {
        $this->giveSecondPlayerScoreTimes(3);

        $expected = 'Love Forty';
        $this->scoreShouldBe($expected);
    }

    public function test_Fiten_All()
    {
        $this->giveFirstPlayerScoreTimes(1);
        $this->giveSecondPlayerScoreTimes(1);

        $expected = 'Fiten All';
        $this->scoreShouldBe($expected);
    }

    public function test_Forty_All()
    {
        $this->giveFirstPlayerScoreTimes(2);
        $this->giveSecondPlayerScoreTimes(2);

        $expected = 'Thirty All';
        $this->scoreShouldBe($expected);
    }

    public function test_Deuce()
    {
        $this->giveDeuce();

        $expected = 'Deuce';
        $this->scoreShouldBe($expected);
    }

    public function test_FirstPlayer_Adv()
    {
        $this->giveDeuce();
        $this->giveFirstPlayerScoreTimes(1);
        $expected = 'Tom Adv';
        $this->scoreShouldBe($expected);
    }

    public function test_SecondPlayer_Adv()
    {
        $this->giveDeuce();
        $this->giveSecondPlayerScoreTimes(1);
        $expected = 'Joe Adv';
        $this->scoreShouldBe($expected);
    }

    public function test_SecondPlayer_Win()
    {
        $this->giveDeuce();
        $this->giveSecondPlayerScoreTimes(2);
        $expected = 'Joe Win';
        $this->scoreShouldBe($expected);
    }

    private function scoreShouldBe(string $expected)
    {
        $score = $this->temmis->score();
        $this->assertEquals($expected, $score);       
    }

    private function giveFirstPlayerScoreTimes(int $time)
    {
        for ($i=0; $i < $time; $i++) { 
            $this->temmis->firstPlayerScore();
        }
    }

    private function giveSecondPlayerScoreTimes(int $time)
    {
        for ($i=0; $i < $time; $i++) { 
            $this->temmis->secondPlayerScore();
        }
    }

    private function giveDeuce(): void
    {
        $this->giveFirstPlayerScoreTimes(3);
        $this->giveSecondPlayerScoreTimes(3);
    }
}

