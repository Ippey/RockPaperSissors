<?php
namespace App\Tests;

use App\Entity\CpuResultLog;
use App\Entity\User;
use App\Repository\CpuResultLogRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BattleControllerTest extends WebTestCase
{
    /** @var KernelBrowser */
    private $client;
    /** @var UserRepository */
    private $userRepository;
    /** @var CpuResultLogRepository */
    private $cpuResultLogRepository;

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->userRepository = static::$container->get(UserRepository::class);
        $this->cpuResultLogRepository = static::$container->get(CpuResultLogRepository::class);
        $user = new User();
        $user->setName('battleTest');
        $user->setPoint(100);
        $this->userRepository->add($user);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testBattleAble(): void
    {
        $user = new User();
        $user->setName('test');
        $user->setPoint(5);
        $this->userRepository->add($user);
        /** @var User $testUser */
        $testUser = $this->userRepository->findOneBy(['name' => 'test']);

        $crawler = $this->client->request('GET', '/battle/'.$testUser->getId());
        // 10pt未満のプレイヤーのじゃんけん画面にはpが5つ、10pt以上は4つ
        $this->assertSame(5, $crawler->filter('p')->count());
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

    /**
     * @throws Exception
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testCPUResult(): void
    {
        $today = new DateTime();
        $cpuResultLogs = $this->cpuResultLogRepository->findResultByToday($today->format('Y-m-d'));
        if (!empty($cpuResultLogs)) {
            foreach ($cpuResultLogs as $cpuResultLog) {
                $this->cpuResultLogRepository->remove($cpuResultLog);
            }
        }
        $cpuResultLog1 = new CpuResultLog();
        $cpuResultLog1->setResult(CpuResultLog::ID_SISSORS);
        $this->cpuResultLogRepository->add($cpuResultLog1);
        $cpuResultLog2 = new CpuResultLog();
        $cpuResultLog2->setResult(CpuResultLog::ID_SISSORS);
        $this->cpuResultLogRepository->add($cpuResultLog2);
        $cpuResultLog3 = new CpuResultLog();
        $cpuResultLog3->setResult(CpuResultLog::ID_ROCK);
        $this->cpuResultLogRepository->add($cpuResultLog3);
        $cpuResultLog4 = new CpuResultLog();
        $cpuResultLog4->setResult(CpuResultLog::ID_PAPER);
        $this->cpuResultLogRepository->add($cpuResultLog4);

        $crawler = $this->client->request('GET', '/battle/1');
        $resultRate = $crawler->filter('#result')->text();
        $this->assertSame('グー：25％　パー：25％　チョキ：50％', $resultRate);
    }
}
