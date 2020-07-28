<?php
namespace App\Tests;

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

    public function testChoiceNullAble(): void
    {
        $bool = false;
        $form = ['myResult' => []];
        $myResult = $form['myResult'];
        if (!empty($myResult)) {
            $bool = true;
        }
        $this->assertFalse($bool);
    }
}
