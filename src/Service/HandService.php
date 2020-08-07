<?php
namespace App\Service;
use App\Entity\CPULogs;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HandService extends AbstractController{
    //CPUの出す手を返す
    public function getHand(int $hand=-1){      
        //0:グー    
        //1:チョキ
        //2:パー
        //handが-1以外の時はそのままの値で処理(デバッグ用)
        if ($hand == -1) {
            $hand = rand(0,2);
        }

        //ログに決めた手を追加
        $manager = $this->getDoctrine()->getManager();
        //現在のユーザーから10ポイント引く
        $user = $this->getUser();
        $point = $user->getPoint() - 10;
        $user->setPoint($point);
        $manager->flush();
        //CPULogsにCPUが選んだ手を追加
        $time = new DateTime("now");
        $cpulog = new CPULogs();
        $cpulog->setDate($time);
        $cpulog->setHand($hand);

        //DBを更新
        $manager->persist($cpulog);
        $manager->flush();
        

        return $hand;
    }

    
    
}