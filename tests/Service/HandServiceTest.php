<?php
//参考サイト：https://symfony.com/doc/current/testing/database.html
namespace App\Tests\Service;
use PHPUnit\Framework\TestCase;
use App\Service\HandService;
use DateTime;
use App\Entity\CPULogs;
use Doctrine\Persistence\ManagerRegistry;

class HandServiceTest extends TestCase
{

    public function test_handservice()
    {
        for ($i=0; $i < 3; $i++) { 
            
            $manager = new ManagerRegistry();
            $testTarget = new HandService($manager);
            $hand = $testTarget->getHand();
            $date = new DateTime("now");

            $repositry = $manager->getRepository(CPULogs::class);
            $result = $repositry->findBy(["hand" => $hand, "date" => $date]);
            $this->assertNotEmpty($result);
        }
        
    }

    
}