<?php

namespace App\Controller;

use App\Entity\CpuResultLog;
use App\Entity\User;
use App\Form\BattleFormType;
use App\Repository\CpuResultLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BattleController extends AbstractController
{
    /**
     * @Route(path="/battle/{id}", name="battle")
     */
    public function battleAction(Request $request, User $user)
    {
        $rockRate = 0;
        $paperRate = 0;
        $sissorsRate = 0;

        $today = new \DateTime();
        /** @var CpuResultLogRepository $cpuResultLogRep */
        $cpuResultLogRep   = $this->getDoctrine()->getRepository(CpuResultLog::class);
        $todayRockDatas    =
            $cpuResultLogRep->findCountByResultAndToday(CpuResultLog::ID_ROCK, $today->format('Y-m-d'));
        $todayPaperDatas   =
            $cpuResultLogRep->findCountByResultAndToday(CpuResultLog::ID_PAPER, $today->format('Y-m-d'));
        $todaySissorsDatas =
            $cpuResultLogRep->findCountByResultAndToday(CpuResultLog::ID_SISSORS, $today->format('Y-m-d'));
        $totalNum = $todayRockDatas + $todayPaperDatas + $todaySissorsDatas;

        if (!empty($totalNum)) {
            $rockRate = $todayRockDatas / $totalNum * 100;
            $paperRate = $todayPaperDatas / $totalNum * 100;
            $sissorsRate = $todaySissorsDatas / $totalNum * 100;
        }

        $form = $this->createForm(BattleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $myResult = $form['myResult']->getData();
            if (!empty($myResult)) {
                return $this->redirectToRoute('result', ['id' => $user->getId(), 'myResult' => $myResult]);
            }
        }
        return $this->render('battle.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'rockRate' => $rockRate,
            'paperRate' => $paperRate,
            'sissorsRate' => $sissorsRate,
        ]);
    }

    /**
     * @Route(path="/reset/{id}", name="reset")
     */
    public function resetAction(User $user)
    {
        $user->setPoint(100);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('battle', ['id' => $user->getId()]);
    }
}
