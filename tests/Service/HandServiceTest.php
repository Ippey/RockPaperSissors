<?php
//参考サイト：https://symfony.com/doc/current/testing/database.html
namespace App\Tests\Service;
use App\Service\HandService;
use DateTime;
use App\Entity\CPULogs;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HandServiceTest extends KernelTestCase
{
    
    public function test_handservice()
    {
        $this->entityManager = self::$kernel->getContainer()
                                            ->get('doctrine')
                                            ->getManager();
        for ($i=0; $i < 3; $i++) { 
            
            $testTarget = new HandService($this->entityManager);
            $hand = $testTarget->getHand();
            $date = new DateTime("now");

            $repositry = $this->entityManager->getRepository(CPULogs::class);
            $result = $repositry->findBy(["hand" => $hand, "date" => $date]);
            $this->assertNotEmpty($result);
        }
        
    }

    
}