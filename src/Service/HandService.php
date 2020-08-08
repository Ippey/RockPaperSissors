<?php
namespace App\Service;

use App\Entity\CPULogs;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

class HandService
{
    private ManagerRegistry $managerRegistry;
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

        
        //CPULogsにCPUが選んだ手を追加
        $time = new DateTime("now");
        $cpulog = new CPULogs();
        $cpulog->setDate($time);
        $cpulog->setHand($hand);

        
        //ログに決めた手を追加してDBを更新
        $manager = $this->managerRegistry->getManager();
        $manager->persist($cpulog);
        $manager->flush();
        

        return $hand;
    }

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
}
