<?php

namespace App;

use App\Repositories\BudgetRepository;
use Carbon\Carbon;
class BudgetService
{
    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function query($startData, $endData)
    {
        // 起晚於訖
        if($startData->format('Ymd') > $endData->format('Ymd')){
            return 0;
        }
        if ($startData->format('Y') === $endData->format('Y')){
            if ($startData->format('Ym') === $endData->format('Ym')) {
                $days = $endData->format('d') - $startData->format('d') + 1;

                return $this->getDailyBudget($startData) * $days;
            }else{

                $diffMonth = $endData->format('m') - $startData->format('m')-1;

                $diffStartdays = $startData->format('t') - $startData->format('d') + 1;
                $budget = $this->getDailyBudget($startData) * $diffStartdays
                    + $this->getDailyBudget($endData) * $endData->format('d');

                for($i = 0 ; $i < $diffMonth ; $i++){
                    $budget += $this->getMonth($startData->modify("-". ($startData->format('d')-1) ." days")->modify("+1 month"));
                }


                return $budget;

            }
        }else{
            $budget = 0;

            $diffYear = $endData->format('Y') - $startData->format('Y') - 1;

            for($i = 0 ; $i < $diffYear ; $i++){
                for ($x=0; $x<12;$x++){
                    $yearMonth = $startData->format('Y') + 1 ;
                    $end = (new \DateTime($yearMonth.'0101'))->modify("+$x month");

                    $budget += $this->getMonth($end);
                }
            }

            $diffStartdays = $startData->format('t') - $startData->format('d') + 1;

            $budget += $this->getDailyBudget($startData) * $diffStartdays;

            $diffStartMonth = 12 - $startData->format('m');

            for($i = 0 ; $i < $diffStartMonth ; $i++){
                $budget += $this->getMonth($startData->modify("-". ($startData->format('d')-1) ." days")->modify("+1 month"));
            }

            $diffEndMonth = $endData->format('m') - 1;

            $budget += $this->getDailyBudget($endData) * $endData->format('d');

            for($i = 0 ; $i < $diffEndMonth ; $i++){
                $budget += $this->getMonth($startData->modify("-". ($startData->format('d')-1) ." days")->modify("+1 month"));
            }

            return $budget;
        }

        return '沒做拉';
    }

    public function getMonth($date): int
    {
        $budgetRepository = $this->budgetRepository->getAll();

        return isset($budgetRepository[$date->format('Ym')])?$budgetRepository[$date->format('Ym')]:0;
    }

    /**
     * @param $startData
     * @return float|int
     */
    private function getDailyBudget($startData)
    {
        return $this->getMonth($startData) / $startData->format('t');
    }
}
