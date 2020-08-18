<?php
namespace App\Tests\Service;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\LogService;
use App\Entity\CPULogs;
use DateTime;

class LogServiceTest extends KernelTestCase
{
    private $entityManager;
    public function test_LogService()
    {
        $kernel = self::bootKernel();
        //最後の物は0件の時を検証する用
        $testCase = array("2020-08-07", "now", "1000-12-15");
        for ($i=0; $i < 3; $i++) { 
            $this->entityManager = $kernel->getContainer()
                                                ->get('doctrine')
                                                ->getManager();
            $repository = $this->entityManager->getRepository(CPULogs::class);
            $testTarget = new LogService($this->entityManager);
            $allGames = count($repository->findBy(["date" => new DateTime($testCase[$i])]));
            //0件の時の処理
            if ($allGames == 0) {
                $expectedGoo = 0;
                $expectedChoki = 0;
                $expectedPar = 0;
            } else {
                $expectedGoo = (float)(count($repository->findBy(["date" => new DateTime($testCase[$i]), "hand" => 0])) / $allGames) * 100;
                $expectedChoki = (float)(count($repository->findBy(["date" => new DateTime($testCase[$i]), "hand" => 1])) / $allGames) * 100;
                $expectedPar = (float)(count($repository->findBy(["date" => new DateTime($testCase[$i]), "hand" => 2])) / $allGames) * 100;
            }

            $this->assertEquals($expectedGoo, $testTarget->getGooRate($testCase[$i]));
            $this->assertEquals($expectedChoki, $testTarget->getChokiRate($testCase[$i]));
            $this->assertEquals($expectedPar, $testTarget->getParRate($testCase[$i]));

        }
        
    }

   

  

   
}

