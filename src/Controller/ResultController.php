<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\HandService;
use App\Service\ResultService;
use Symfony\Component\HttpFoundation\Request;

class ResultController extends AbstractController
{
    /**
     * @Route("/result", name="result")
     */
    public function index(HandService $handservice, ResultService $resultService, Request $request)
    {
        $cpuhand = $handservice->getHand();
        $playerhand = $request->request->get('hand');
        $result = $resultService->getResult($playerhand,$cpuhand);
        $resultMessage = $result->getResultMessage();
        $point = $result->getPoint();
        return $this->render('result/index.html.twig', [
           'resultMessage' => $resultMessage,
           'point' => $point,
        ]);
    }
}
