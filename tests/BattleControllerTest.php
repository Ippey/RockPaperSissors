<?php
namespace App\Tests;

use App\Entity\CpuResultLog;
use App\Entity\User;
use App\Repository\CpuResultLogRepository;
use App\Repository\UserRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BattleControllerTest extends WebTestCase
{
    public function testBattleAble(): void
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $user = new User();
        $user->setName('test');
        $user->setPoint(5);
        $userRepository->add($user);
        /** @var User $testUser */
        $testUser = $userRepository->findOneBy(['name' => 'test']);

        $crawler = $client->request('GET', '/battle/'.$testUser->getId());
        // 10pt未満のプレイヤーのじゃんけん画面にはpが5つ、10pt以上は4つ
        $this->assertSame(5, $crawler->filter('p')->count());
    }

    public function testChoiceNullAble(): void
    {
        $nullAble = true;
        $client = static::createClient();
        $crawler = $client->request('GET', '/battle/1');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form = $buttonCrawlerNode->form();
        try {
            $client->submit($form, [
                'battle_form[myResult]' => '',
            ]);
        } catch (Exception $exception) {
            $nullAble = false;
        } finally {
            $this->assertFalse($nullAble);
        }
    }

    /**
     * @throws Exception
     */
    public function testCPUResult(): void
    {
        $today = new DateTime();
        $client = static::createClient();
        /** @var CpuResultLogRepository $cpuResultLogRepository */
        $cpuResultLogRepository = static::$container->get(CpuResultLogRepository::class);
        $cpuResultLogs = $cpuResultLogRepository->findResultByToday($today->format('Y-m-d'));
        if (!empty($cpuResultLogs)) {
            foreach ($cpuResultLogs as $cpuResultLog) {
                $cpuResultLogRepository->remove($cpuResultLog);
            }
        }
        $cpuResultLog1 = new CpuResultLog();
        $cpuResultLog1->setResult(CpuResultLog::ID_SISSORS);
        $cpuResultLogRepository->add($cpuResultLog1);
        $cpuResultLog2 = new CpuResultLog();
        $cpuResultLog2->setResult(CpuResultLog::ID_SISSORS);
        $cpuResultLogRepository->add($cpuResultLog2);
        $cpuResultLog3 = new CpuResultLog();
        $cpuResultLog3->setResult(CpuResultLog::ID_ROCK);
        $cpuResultLogRepository->add($cpuResultLog3);
        $cpuResultLog4 = new CpuResultLog();
        $cpuResultLog4->setResult(CpuResultLog::ID_PAPER);
        $cpuResultLogRepository->add($cpuResultLog4);

        $crawler = $client->request('GET', '/battle/1'); //userId 1 は10pt以上ないとダメ
        $resultRate = $crawler->filterXpath('//p[3]')->text();
        $this->assertSame('グー：25％　パー：25％　チョキ：50％', $resultRate);
    }
}
