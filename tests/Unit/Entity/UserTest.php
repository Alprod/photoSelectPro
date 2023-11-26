<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Binomial;
use App\Entity\Client;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testInstanceOf(): void
    {
        self::assertInstanceOf(User::class, $this->user);
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

    public function testSetAndGetCreatedAt(): void
    {
        $date = new \DateTimeImmutable('now');
        $this->user->setCreatedAt($date);
        self::assertEquals($date, $this->user->getCreatedAt());
    }

    public function testSetAndGetUserClient(): void
    {
        $client = new Client();
        $name = 'chanel';
        $user = $this->user;

        $user->setClient($client);
        $user->getClient()->setName($name);

        self::assertNotNull($user->getClient());
        self::assertEquals($name, $user->getClient()->getName());
    }

    public function testSetAndGetFirstBinomialAndSecondBinomial(): void
    {
        $binomial = new Binomial();
        $user = $this->user;
        $user->addFirstBinomial($binomial);
        $user->addSecondBinomial($binomial);

        self::assertNotNull($user->getFirstBinomials());
        self::assertNotNull($user->getSecondBinomials());

        self::assertIsObject($user->getFirstBinomials());
        self::assertIsObject($user->getSecondBinomials());

    }
}
