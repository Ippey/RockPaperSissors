<?php

namespace App\Service;
use DateTime;
use App\Entity\CPULogs;
use Doctrine\ORM\EntityManagerInterface;


class HandService
{
    private EntityManagerInterface $managerRegistry;
    //CPUの出す手を返す
    public function getHand(int $hand = -1, string $date="now")
    {
        //0:グー
        //1:チョキ
        //2:パー
        //handが-1以外の時はそのままの値で処理(デバッグ用)
        if ($hand == -1) {
            $hand = rand(0, 2);
        }

        //CPULogsにCPUが選んだ手を追加
        $time = new DateTime($date);
        $cpulog = new CPULogs($hand, $time);

        //ログに決めた手を追加してDBを更新
        $this->managerRegistry->persist($cpulog);
        $this->managerRegistry->flush();
        

        return $hand;
    }

    public function __construct(EntityManagerInterface $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

   
}