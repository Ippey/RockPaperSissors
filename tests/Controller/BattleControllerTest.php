<?php
namespace App\Tests;

use App\Entity\User;
use App\Entity\CpuResultLog;
use App\Repository\UserRepository;
use App\Repository\CpuResultLogRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BattleControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->client = static::createClient();
        $this->userRepository = static::$container->get(UserRepository::class);
        $this->cpuResultLogRepository = static::$container->get(CpuResultLogRepository::class);
        $user = new User();
        $user->setName('BattleTest');
        $user->setPoint(100);
        $this->userRepository->add($user);
    }

    public function testChoiceNullAble(): void
    {
        $nullAble = true;
        $crawler = $this->client->request('GET', '/battle/1');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form = $buttonCrawlerNode->form();
        try {
            $this->client->submit($form, [
                'battle_form[myResult]' => '',
            ]);
        } catch (Exception $exception) {
            $nullAble = false;
        } finally {
            $this->assertFalse($nullAble);
        }
    }

    public function testBattleAble(): void
    {
        $user = new User();
        $user->setName('Point5');
        $user->setPoint(5);
        $this->userRepository->add($user);
        $testUser = $this->userRepository->findOneBy(['name' => 'Point5']);
        $crawler = $this->client->request('GET', '/battle/'.$testUser->getId());
        $this->assertCount(4, $crawler->filter('p'));
    }

    public function testCPUResult(): void
    {
        $today = new \DateTime();
        $cpuResultLogs = $this->cpuResultLogRepository->findResultByToday($today->format('Y-m-d'));
        if (!empty($cpuResultLogs)) {
            foreach ($cpuResultLogs as $cpuResultLog) {
                $this->cpuResultLogRepository->remove($cpuResultLog);
            }
        }
        $cpuResultLog1 = new CpuResultLog();
        $cpuResultLog1->setResult(CpuResultLog::ID_ROCK);
        $this->cpuResultLogRepository->add($cpuResultLog1);
        $cpuResultLog2 = new CpuResultLog();
        $cpuResultLog2->setResult(CpuResultLog::ID_PAPER);
        $this->cpuResultLogRepository->add($cpuResultLog2);
        $cpuResultLog3 = new CpuResultLog();
        $cpuResultLog3->setResult(CpuResultLog::ID_SISSORS);
        $this->cpuResultLogRepository->add($cpuResultLog3);
        $cpuResultLog4 = new CpuResultLog();
        $cpuResultLog4->setResult(CpuResultLog::ID_SISSORS);
        $this->cpuResultLogRepository->add($cpuResultLog4);

        $crawler = $this->client->request('GET', '/battle/1');
        $resultRate = $crawler->filter('#result')->text();
        $this->assertSame('グー：25％　パー：25％　チョキ：50％', $resultRate);
    }
}
