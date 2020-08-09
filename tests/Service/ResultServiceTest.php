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
                $result = $testTarget->getResult($i, $j);
                //あいこの時のテスト
                if($i == $j){
                    $this->assertEquals(0, $result["point"]);
                    $this->assertEquals("あいこです", $result["resultMessage"]);
                } elseif($i == 0 && $j == 1 ||
                         $i == 1 && $j == 2 ||
                         $i == 2 && $j == 0 ){
                    
                    //勝利時のテスト
                    $this->assertEquals(15, $result["point"]);
                    $this->assertEquals("あなたの勝ちです", $result["resultMessage"]);

                } else{
                    //敗北時のテスト
                    $this->assertEquals(0, $result["point"]);
                    $this->assertEquals("あなたの負けです", $result["resultMessage"]);

                }



            }
        }
    }
}