<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\HandService;
use App\Service\ResultService;
use App\Service\LogService;
use App\Entity\CPULogs;
use DateTime;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    
    public function index(
        HandService $handservice,
        ResultService $resultService,
        LogService $logService,
        Request $request
    ) {
        $playerhand = $request->request->get('hand');
        $buttonMessage = $request->request->get('button');
        $user = $this->getUser();
        $message = "";
        if ($playerhand == null) {
            //入力がないときは何もせずリダイレクト
            $message = 'グー、チョキ、パーのいずれかを選択してください。';
        } elseif ($user->getPoint() < 10) {
            $message = "ポイントが不足しています。";
        } elseif ($buttonMessage == "じゃんけんする") {
            $buttonMessage = "";
            
            //現在のユーザーから10ポイント引く
            $user->setPoint($user->getPoint() - 10);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $cpuhand = $handservice->getHand();
            
            //CPULogsにCPUが選んだ手を追加
            $time = new DateTime("now");
            $cpulog = new CPULogs();
            $cpulog->setDate($time);
            $cpulog->setHand($cpuhand);
            //ログに決めた手を追加してDBを更新
            $manager->persist($cpulog);
            $manager->flush();


            $result = $resultService->getResult($playerhand, $cpuhand);
            $message = $result["resultMessage"];
            $user->setPoint($user->getPoint() + $result["point"]);
            $manager->flush();
        }
        if ($buttonMessage == "ポイントをリセット") {
            $buttonMessage = "";
            
            $user->setPoint(100);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $message = 'ポイントをリセットしました。';
        }

        return $this->render("main/index.html.twig", [
            'Message' => $message,
            'goo' => $logService->getGooRate(),
            'choki' => $logService->getChokiRate(),
            'par' => $logService->getParRate(),
            'currentPoint' => $user->getPoint(),

        ]);
    }
}
