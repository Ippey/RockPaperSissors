<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testAddUser(): void
    {
        $user = new User();
        $user->setName('');
        $user->setPoint(100);

        $this->assertEquals(100, $user->getPoint());
    }
}
