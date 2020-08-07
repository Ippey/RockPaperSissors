<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\HandService;
use App\Service\ResultService;
use App\Service\LogService;
use ErrorException;
use HandService as GlobalHandService;


class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    
    public function index(HandService $handservice, ResultService $resultService,
                          LogService $logService, Request $request){
        $playerhand = $request->request->get('hand');
        $buttonMessage = $request->request->get('button');
        echo $buttonMessage;
        $user = $this->getUser();
        $target = "main/index.html.twig";
        $message = "";
        if($playerhand == null) {
            //入力がないときは何もせずリダイレクト
            $message = 'グー、チョキ、パーのいずれかを選択してください。';
            $target = "main/index.html.twig";

        }elseif ($user->getPoint() < 10) {
            $target = "main/index.html.twig";
            $message = "ポイントが不足しています。";
            
        } elseif($buttonMessage == "じゃんけんする"){
            $buttonMessage = "";
            $target = "result/index.html.twig";
            $cpuhand = $handservice->getHand();
            $result = $resultService->getResult($playerhand,$cpuhand);
            $message = $result["resultMessage"];
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            
        }
        if ($buttonMessage == "ポイントをリセット") {
            $buttonMessage = "";
            $target = "main/index.html.twig";
            $user->setPoint(100);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $message = 'ポイントをリセットしました。';
                
        }

        return $this->render($target, [
            'Message' => $message,
            'goo' => $logService->getGooRate(),
            'choki' => $logService->getChokiRate(),
            'par' => $logService->getParRate(),
            'currentPoint' => $user,

        ]);
    }
}
