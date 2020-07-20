<?php
namespace App\Controller;

use App\Entity\CpuResultLog;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends AbstractController
{
    /**
     * @Route(path="/result/{id}/{myResult}", name="result")
     * @param User $user
     * @param $myResult
     * @return Response
     */
    public function loginAction(User $user, $myResult)
    {
        $beforePoint = $user->getPoint();
        $cpuResult = rand(1,3);
        $cpuResultLog = new CpuResultLog();
        $cpuResultLog->setResult($cpuResult);
        if (($myResult - $cpuResult) == -2 || ($myResult - $cpuResult) == 1){
            // 勝時
            $user->setPoint($beforePoint + 5);
            $result = '勝ち';
        } elseif (($myResult - $cpuResult) == 0){
            $user->setPoint($beforePoint - 10);
            $result = '引き分け';
        } else{
            $user->setPoint($beforePoint - 10);
            $result = '負け';
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($cpuResultLog);
        $em->flush();

        return $this->render('result.html.twig', [
            'result' => $result,
            'user' => $user
        ]);
    }
}