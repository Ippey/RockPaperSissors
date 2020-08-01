<?php
namespace App\Tests;

use App\Entity\CpuResultLog;
use App\Service\JankenService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResultControllerTest extends WebTestCase
{
    /** @var JankenService */
    private $jankenService;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        self::$container = $kernel->getContainer();
        $this->jankenService = self::$container->get(JankenService::class);
    }

    public function testResultAction(): void
    {
        $myResult = CpuResultLog::ID_ROCK;
        $cpuResult = CpuResultLog::ID_SISSORS;
        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $this->assertEquals(5, $plusPoint);
        $this->assertEquals('勝ち', $result);

        $myResult = CpuResultLog::ID_SISSORS;
        $cpuResult = CpuResultLog::ID_PAPER;
        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $this->assertEquals(5, $plusPoint);
        $this->assertEquals('勝ち', $result);

        $myResult = CpuResultLog::ID_PAPER;
        $cpuResult = CpuResultLog::ID_ROCK;
        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $this->assertEquals(5, $plusPoint);
        $this->assertEquals('勝ち', $result);

        $myResult = CpuResultLog::ID_ROCK;
        $cpuResult = CpuResultLog::ID_ROCK;
        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $this->assertEquals(-10, $plusPoint);
        $this->assertEquals('引き分け', $result);

        $myResult = CpuResultLog::ID_SISSORS;
        $cpuResult = CpuResultLog::ID_SISSORS;
        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $this->assertEquals(-10, $plusPoint);
        $this->assertEquals('引き分け', $result);

        $myResult = CpuResultLog::ID_PAPER;
        $cpuResult = CpuResultLog::ID_PAPER;
        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $this->assertEquals(-10, $plusPoint);
        $this->assertEquals('引き分け', $result);

        $myResult = CpuResultLog::ID_SISSORS;
        $cpuResult = CpuResultLog::ID_ROCK;
        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $this->assertEquals(-10, $plusPoint);
        $this->assertEquals('負け', $result);

        $myResult = CpuResultLog::ID_PAPER;
        $cpuResult = CpuResultLog::ID_SISSORS;
        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $this->assertEquals(-10, $plusPoint);
        $this->assertEquals('負け', $result);

        $myResult = CpuResultLog::ID_ROCK;
        $cpuResult = CpuResultLog::ID_PAPER;
        list($plusPoint, $result) = $this->jankenService->jankenAction($myResult, $cpuResult);
        $this->assertEquals(-10, $plusPoint);
        $this->assertEquals('負け', $result);
    }
}
