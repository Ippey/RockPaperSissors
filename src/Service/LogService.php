<?php
namespace App\Service;
use DateTime;
use App\Entity\CPULogs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;

class LogService extends AbstractController{

    public function getGooRate(){
        $repository = $this->getDoctrine()->getRepository(CPULogs::class);
        $todayActions = count($repository->findBy(['date' => new DateTime('now')]));
        //このif文で0除算を回避
        if($todayActions == 0){
            return 0;
        }
        $goos = count($repository->findBy(['date' => new DateTime('now'), 'hand' => 0]));
        return (float)$goos / ((float)$todayActions) * 100;
    }

    public function getChokiRate(){
        $repository = $this->getDoctrine()->getRepository(CPULogs::class);
        $todayActions = count($repository->findBy(['date' => new DateTime('now')]));
        //このif文で0除算を回避
        if($todayActions == 0){
            return 0;
        }
        $chokis = count($repository->findBy(['date' => new DateTime('now'), 'hand' => 1]));
        return ((float)$chokis / (float)$todayActions) * 100;
    }
    public function getParRate(){
        $repository = $this->getDoctrine()->getRepository(CPULogs::class);
        $todayActions = count($repository->findBy(['date' => new DateTime('now')]));
        //このif文で0除算を回避
        if($todayActions == 0){
            return 0;
        }
        $pars = count($repository->findBy(['date' => new DateTime('now'), 'hand' => 2]));
        return ((float)$pars / (float)$todayActions) * 100;
    }



}