<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/26
 * Time: 下午 05:18
 */

namespace App;

class Tennis
{
    private $firstPlayerName;
    
    private $secondPlayerName;

    private $firstPlayerScoreTimes = 0;
    
    private $secondPlayerScoreTimes = 0;

    private $scoreLookup = [
        0 => 'Love',
        1 => 'Fiten',
        2 => 'Thirty',
        3 => 'Forty',
    ];

    public function __construct(string $firstPlayerName, string $secondPlayerName)
    {
        $this->firstPlayerName = $firstPlayerName;
        $this->secondPlayerName = $secondPlayerName;
    }

    public function score()
    {
        if($this->isScoreDofferent()){
            if ($this->firstPlayerScoreTimes > 3 || $this->secondPlayerScoreTimes > 3) {

                if($this->firstPlayerScoreTimes > $this->secondPlayerScoreTimes && abs($this->firstPlayerScoreTimes-$this->secondPlayerScoreTimes)==1){
                    return $this->firstPlayerName . " Adv";
                }else if ($this->firstPlayerScoreTimes < $this->secondPlayerScoreTimes && abs($this->firstPlayerScoreTimes-$this->secondPlayerScoreTimes)==1){
                    return $this->secondPlayerName . " Adv";
                }
            }else{
                return $this->lookupScore();
            }
        }

        if($this->sameScore()){
            if ($this->firstPlayerScoreTimes >= 3){
                return "Deuce";
            }else{
                return $this->scoreLookup[$this->firstPlayerScoreTimes] ." All";
            }
        }

        return "Love All";
    }

    public function sameScore()
    {
        return $this->firstPlayerScoreTimes == $this->secondPlayerScoreTimes;
    }

    private function isScoreDofferent()
    {
        return $this->firstPlayerScoreTimes != $this->secondPlayerScoreTimes;
    }

    private function lookupScore()
    {
        return $this->scoreLookup[$this->firstPlayerScoreTimes] . " " . $this->scoreLookup[$this->secondPlayerScoreTimes];

    }

    public function firstPlayerScore()
    {
        $this->firstPlayerScoreTimes++;
    }

    public function secondPlayerScore()
    {
        $this->secondPlayerScoreTimes++;
    }
}
