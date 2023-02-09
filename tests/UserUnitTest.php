<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testIsTrue()
    {
        $user = new User();
        $user->setEmail('info@sn.eh')
            ->setUsername('ikasle')
            ->setPassword('password');
        $this->assertTrue($user->getEmail() === 'info@sn.eh');
        $this->assertTrue($user->getUsername() ===  'ikasle');
        $this->assertTrue($user->getPassword() ===  'password');

    }

    public function testIsFalse()
    {
        $user = new User();
        $user->setEmail('info@sn.eh')
            ->setUsername('ikasle')
            ->setPassword('password');
        $this->assertFalse($user->getEmail() ===  'false@sn.eh');
        $this->assertFalse($user->getUsername() === 'false');
        $this->assertFalse($user->getPassword() ===  'false');

    }
    public function testIsEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getEmail() );
        $this->assertEmpty($user->getUsername() );
        $this->assertEmpty($user->getPassword() );

    }
}
