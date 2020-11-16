<?php
namespace App\Controller;

use App\Entity\CpuResultLog;
use App\Entity\User;
use App\Service\JankenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends AbstractController
{
    public $jankenService;

    public function __construct(JankenService $jankenService)
    {
        $this->jankenService = $jankenService;
    }

    /**
     * @Route(path="/result/{id}/{myResult}", name="result")
     */
    public function resultAction(User $user, $myResult)
    {
        $beforePoint = $user->getPoint();
        $cpuResult = rand(1, 3);
        $cpuResultLog = new CpuResultLog();
        $cpuResultLog->setResult($cpuResult);

        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $user->setPoint($beforePoint + $plusPoint);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cpuResultLog);
        $entityManager->flush();

        return $this->render('result.html.twig', [
            'result' => $result,
            'user' => $user
        ]);
    }
}
