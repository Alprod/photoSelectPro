<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testSetAndGetEmail(): void
    {
        $email = 'JohnDoe@demo.fr';
        $this->user->setEmail($email);

        $this->assertEquals($email, $this->user->getEmail());
    }

    public function testSetAndGetRole(): void
    {
        $role = ['ROLE_USER'];
        $this->user->setRoles($role);
        self::assertIsArray($this->user->getRoles());
        self::assertContains('ROLE_USER', $this->user->getRoles());
    }
}
