<?php
namespace App\Tests\Service;
use PHPUnit\Framework\TestCase;

use App\Service\LogService;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\CPULogs;
use DateTime;

/**
 * @dataProvider provideTestCase
 */
class LogServiceTest extends TestCase{
    public function LogServiceTest($testCase)
    {
        $manager = new ManagerRegistry();
        $repository = $manager->getRepository(CPULogs::class);
        $testTarget = new LogService(new ManagerRegistry());
        $allGames = count($repository->findBy(["date" => new DateTime($testCase)]));
        //0件の時の処理
        if ($allGames == 0) {
            $expectedGoo = 0;
            $expectedChoki = 0;
            $expectedPar = 0;
        } else{
            $expectedGoo = (count($repository->findBy(["date" => new DateTime($testCase), "hand" => 0])) / $allGames) * 100;
            $expectedChoki = (count($repository->findBy(["date" => new DateTime($testCase), "hand" => 1])) / $allGames) * 100;
            $expectedPar = (count($repository->findBy(["date" => new DateTime($testCase), "hand" => 2])) / $allGames) * 100;
        }

        $this->assertEquals($expectedGoo, $testTarget->getGooRate());
        $this->assertEquals($expectedChoki, $testTarget->getChokiRate());
        $this->assertEquals($expectedPar, $testTarget->getParRate());


        
    }

    public function provideTestCase()
{
    return [
        ["2020-08-07"],
        ["now"],
        ["1000-12-15"] //0件の時
    ];
}
}

