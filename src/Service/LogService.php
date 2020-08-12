<?php
namespace App\Service;

use DateTime;
use App\Entity\CPULogs;
use Doctrine\ORM\EntityManagerInterface;

class LogService
{
    private EntityManagerInterface $managerRegistry;

    public function getGooRate(string $date="now") 
    {
        $repository = $this->managerRegistry->getRepository(CPULogs::class);
        $todayActions = count($repository->findBy(['date' => new DateTime($date)]));
        //このif文で0除算を回避
        if ($todayActions == 0) {
            return 0;
        }
        $goos = count($repository->findBy(['date' => new DateTime($date), 'hand' => 0]));
        return (float)$goos / ((float)$todayActions) * 100;
    }

    public function getChokiRate(string $date="now") {
        $repository = $this->managerRegistry->getRepository(CPULogs::class);
        $todayActions = count($repository->findBy(['date' => new DateTime($date)]));
        //このif文で0除算を回避
        if ($todayActions == 0) {
            return 0;
        }
        $chokis = count($repository->findBy(['date' => new DateTime($date), 'hand' => 1]));
        return ((float)$chokis / (float)$todayActions) * 100;
    }
    public function getParRate(string $date="now") {
        $repository = $this->managerRegistry->getRepository(CPULogs::class);
        $todayActions = count($repository->findBy(['date' => new DateTime($date)]));
        //このif文で0除算を回避
        if ($todayActions == 0) {
            return 0;
        }
        $pars = count($repository->findBy(['date' => new DateTime($date), 'hand' => 2]));
        return ((float)$pars / (float)$todayActions) * 100;
    }

    public function __construct(EntityManagerInterface $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
    }
}
