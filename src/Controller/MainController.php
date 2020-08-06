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
        $user = $this->getUser();
        try{
            $isReset = $_POST['reset'];
        }
        catch(ErrorException $error){
            $isReset = false;
        }
    

        if ($playerhand == null) {
            //入力がないときは何もせずリダイレクト
            return $this->render('main/index.html.twig', [
                'Message' => 'グー、チョキ、パーのいずれかを選択してください。',
                'goo' => $logService->getGooRate(),
                'choki' => $logService->getChokiRate(),
                'par' => $logService->getParRate(),
                'currentPoint' => $user->getPoint(),
            ]);

        }elseif ($user->getPoint() < 10) {
            return $this->render('main/index.html.twig', [
                'Message' => 'ポイントが不足しています。',
                'goo' => $logService->getGooRate(),
                'choki' => $logService->getChokiRate(),
                'par' => $logService->getParRate(),
                'currentPoint' => $user->getPoint(),
            ]);
        } else{
            $cpuhand = $handservice->getHand();
            $result = $resultService->getResult($playerhand,$cpuhand);
            $resultMessage = $result->getResultMessage();
            $point = $result->getPoint();
            return $this->render('result/index.html.twig', [
                'resultMessage' => $resultMessage
            ]);
        }
        if ($isReset == true) {
            $user->setPoint(100);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $isReset = false;
            return $this->render('main/index.html.twig', [
                'Message' => 'ポイントをリセットしました。',
                'goo' => $logService->getGooRate(),
                'choki' => $logService->getChokiRate(),
                'par' => $logService->getParRate(),
                'currentPoint' => $user->getPoint(),
            ]);
        }
    }
}
