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
    public $game = [];
    public $scoreNmae = [
        0 => 'Love',
        1 => 'Fiten',
        2 => 'Thirty',
        3 => 'Forty',
    ];

    public function __construct(string $player1, string $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->player1Score = 0;
        $this->player2Score = 0;
    }

    public function score()
    {
        if($this->player1Score == $this->player2Score){
            return $this->scoreNmae[$this->player1Score] . " " . $this->sameScore();
        }

        if ($score1 == $souce2){
            return $this->scoreNmae[$score1] . 'All';
        }

        return ;
    }

    public function sameScore()
    {
        $score = abs($this->player1Score - $this->player2Score);

        if ($score == 0){
            return 'All';
        }else if($score == 1){
            return 'Adv';
        }else{
            return 'Win';

        }
    }

    public function goal(string $playerName, int $souce = 0)
    {
        if (isset($this->game[$player])) {
            ($souce == 0 )? $this->game[$player]++ : $this->game[$player] = $souce;
        }
    }
}
