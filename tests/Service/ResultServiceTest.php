<?php
namespace App\Tests\Service;

use App\Service\ResultService;
use PHPUnit\Framework\TestCase;

class ResultServiceTest extends TestCase{
    public function TestResult()
    {
        $testTarget = new ResultService();

        for($i = 0; $i < 3; $i++){
            for($j = 0; $j < 3; $j++){
                $result = $testtarget->getResult($i, $j);
                //あいこの時のテスト
                if($i == $j){
                    $this->assertEquals($result["point"], 0);
                    $this->assertEquals($result["resultMessage"],"あいこです");
                } elseif($i == 0 && $j == 1 ||
                         $i == 1 && $j == 2 ||
                         $i == 2 && $j == 0 ){
                    
                    //勝利時のテスト
                    $this->assertEquals($result["point"], 15);
                    $this->assertEquals($result["resultMessage"],"あなたの勝ちです");

                } else{
                    //敗北時のテスト
                    $this->assertEquals($result["point"], 0);
                    $this->assertEquals($result["resultMessage"],"あなたの負けです");

                }



            }
        }
    }
}