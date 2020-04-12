<?php

namespace Tests\Unit\Models;

use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Models\User\UserModel;
use Tests\Unit\ModelTestCase;

/**
 * Class UserModelTest
 *
 * @package Tests\Unit\Models
 */
class UserModelTest extends ModelTestCase
{
    /**
     * @var array
     */
    protected $tables = ['users'];

    /**
     * @var UserModel
     */
    protected $userModel;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->userModel = new UserModel($this->db);
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testStoreUser()
    {
        $user = $this->buildUser();
        $this->userModel->store($user);
        $storedUser = $this->userModel->get($user->getName());

        $this->assertSame(
            'dallas@example.com',
            $storedUser->getEmail(),
            'Email is incorrect.'
        );
    }

    /**
     * @throws NotFoundException
     * @throws DbException
     */
    public function testUserNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->userModel->get('dallas');
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testGetUser()
    {
        $user = $this->buildUser();
        $this->insertUser($user);

        $user = $this->userModel->get($user->getName());

        $this->assertSame(
            'dallas@example.com',
            $user->getEmail(),
            'Email is incorrect.'
        );
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testDeleteUser()
    {
        $this->expectException(NotFoundException::class);

        $user = $this->buildUser();
        $this->insertUser($user);

        $user = $this->userModel->get('dallas');

        $this->assertSame(
            'dallas@example.com',
            $user->getEmail(),
            'Email is incorrect.'
        );

        $this->userModel->delete('dallas');

        $this->userModel->get('dallas');
    }
}
