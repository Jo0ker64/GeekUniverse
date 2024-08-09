<?php

namespace Tests\Service;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetUser()
    {
        $user = new User();
        $user->setUsername('Peter Parker');

        $this->assertEquals('Peter Parker', $user->getUsername());
    }

    public function testSetUser()
    {
        $user = new User();
        $user->setUsername('Peter Parker');

        $this->assertEquals('Peter Parker', $user->getUsername());
    }
}   