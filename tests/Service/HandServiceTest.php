<?php
//参考サイト：https://symfony.com/doc/current/testing/database.html
namespace App\Tests\Service;
use PHPUnit\Framework\TestCase;
use App\Service\HandService;
use DateTime;
use App\Entity\CPULogs;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @dataProvider provideTestCase
 */
class HandServiceTest extends TestCase{
    public function HandTest($testCase)
    {
        $manager = new ManagerRegistry();
        $testTarget = new HandService($manager);
        $hand = $testTarget->getHand($testCase[0],$testCase[1]);
        $date = $testCase[1];

        $repositry = $manager->getRepository(CPULogs::class);
        $result = $repositry->findBy(["hand" => $hand, "date" => $date]);
        $this->assertNotEmpty($result);

        
    }

    public function provideTestCase()
    {
        return [
            [0, "now"],
            [1, "now"],
            [2, "now"],
        ];
    }
}