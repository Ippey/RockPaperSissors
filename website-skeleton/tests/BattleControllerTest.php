<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class BattleControllerTest extends TestCase
{
    public function testBattleAble(): void
    {
        $user = new User();
        $user->setPoint(5);
        if ($user->getPoint() >= 10) {
            $result = '勝負できる';
        } else {
            $result = '勝負できない';
        }
        $this->assertEquals($result, '勝負できない');
    }
}
