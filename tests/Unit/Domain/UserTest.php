<?php

namespace Tests\Unit\Domain;

use Tests\AbstractTestCase;
use App\Domain\User;

/**
 * Class UserTest
 *
 * @package Tests\Unit\Domain
 */
class UserTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testClassInstance()
    {
        $user = new User();

        $this->assertInstanceOf(
            User::class,
            $user,
            'Created object is not the instance of the User class.'
        );
    }

    /**
     * @test
     */
    public function testCreateUserAndCheckData()
    {
        $user = $this->createUser();

        $this->assertSame('John', $user->getName(), 'Name is incorrect.');

        $this->assertSame('john', $user->getSlug(), 'Slug is incorrect.');

        $this->assertSame(
            'john@example.com',
            $user->getEmail(),
            'Email is incorrect.'
        );

        $this->assertSame(
            'a1b1c1d1e1',
            $user->getPassword(),
            'Password is incorrect.'
        );
    }

    /**
     * @test
     */
    public function testChangeName()
    {
        $user = $this->createUser();

        $user->setName('Mark');

        $this->assertSame('Mark', $user->getName(), 'Name is incorrect.');
    }

    /**
     * @test
     */
    public function testChangeEmail()
    {
        $user = $this->createUser();

        $user->setEmail('mark@example.com');

        $this->assertSame(
            'mark@example.com',
            $user->getEmail(),
            'Email is incorrect.'
        );
    }

    /**
     * @test
     */
    public function testChangePassword()
    {
        $user = $this->createUser();

        $user->setPassword('a2b2c2d2e2f2');

        $this->assertSame(
            'a2b2c2d2e2f2',
            $user->getPassword(),
            'Password is incorrect.'
        );
    }

    /**
     * @return User
     */
    private function createUser(): User
    {
        $user = new User();

        return $user->create('John', 'john', 'john@example.com', 'a1b1c1d1e1');
    }
}
