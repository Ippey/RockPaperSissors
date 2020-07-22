<?php

use App\Entity\CpuResultLog;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ResultControllerTest extends TestCase
{
    public function testResultAction(): void
    {
        $user = new User();
        $user->setPoint(100);
        $beforePoint = $user->getPoint();
        $myResult = CpuResultLog::ID_ROCK;
        $cpuResult = CpuResultLog::ID_SISSORS;
        if (($myResult - $cpuResult) == -2 || ($myResult - $cpuResult) == 1) {
            $user->setPoint($beforePoint + 5);
            $result = '勝ち';
        } elseif (($myResult - $cpuResult) == 0) {
            $user->setPoint($beforePoint - 10);
            $result = '引き分け';
        } else {
            $user->setPoint($beforePoint - 10);
            $result = '負け';
        }
        $this->assertEquals(105, $user->getPoint());
        $this->assertEquals('勝ち', $result);
    }
}
