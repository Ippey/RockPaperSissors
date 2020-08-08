<?php
namespace App\Service;

class HandService
{
    //CPUの出す手を返す
    public function getHand(int $hand = -1)
    {
        //0:グー
        //1:チョキ
        //2:パー
        //handが-1以外の時はそのままの値で処理(デバッグ用)
        if ($hand == -1) {
            $hand = rand(0, 2);
        }
        

        return $hand;
    }

   
}
