<?php

namespace App\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

class ResultService extends AbstractController{
    //プレイヤーの手とCPUの手をもらうとゲーム結果を返す
    //見方：(プレイヤーの手(数値))-(CPUの手(数値))
    public function getResult(int $playerHand, int $cpuHand){
        $result = -1;
        //getResult内部で勝利は0、あいこは1、負けは2として扱う
        //あいこパターン
        //1-1,2-2,3-3(プレイヤーとCPUの手が同じ)
        if ($playerHand==$cpuHand) {
           $result = 1;
        }
        //プレイヤー勝利パターン
        //0-1(プレイヤー：グー、CPU：チョキ)
        //1-2(プレイヤー：チョキ、CPU：パー)
        //2-0(プレイヤー：パー、CPU：グー)
        elseif($playerHand == 0 && $cpuHand == 1 ||
               $playerHand == 1 && $cpuHand == 2 ||
               $playerHand == 2 && $cpuHand == 0){
            $result = 0;

        }
        else{
          //プレイヤー敗北パターン
          //1-0(プレイヤー：チョキ、CPU：グー)
          //2-1(プレイヤー：パー、CPU：チョキ)
          //0-2(プレイヤー：グー、CPU：パー)
           $result = 2;       
        }

        $point = $this->getPoint($result);
        $Message = $this->getResultMessage($result);
        return array(
               "point" => $point,
               "resultMessage" => $Message
        );




        
    }

    private function getPoint(int $result){
        if($result == 0){
            //ユーザーが勝った時に15ポイント足す
            $user = $this->getUser();
            $point = $user->getPoint() + 15;
            $user->setPoint($point);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            
            return 15;
        }
        else{
            return 0;
        }
        
    }

    private function getResultMessage(int $result){
        if ($result == 0) {
            return "あなたの勝ちです";
        }
        elseif ($result == 1) {
            return "あいこです";
        }
        else{
            return "あなたの負けです";
        }

    }

    

}

