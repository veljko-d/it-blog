<?php

namespace Tests\Unit\Models;

use App\Domain\User;
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
        $storedUser = $this->userModel->get('dallas');

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
        $this->insertUserIntoTheDatabase();

        $user = $this->userModel->get('dallas');

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

        $this->insertUserIntoTheDatabase();

        $user = $this->userModel->get('dallas');

        $this->assertSame(
            'dallas@example.com',
            $user->getEmail(),
            'Email is incorrect.'
        );

        $this->userModel->delete('dallas');

        $this->userModel->get('dallas');
    }

    /**
     * Insert new User into the database
     */
    private function insertUserIntoTheDatabase()
    {
        $params = [
            ':name'     => 'Dallas',
            ':slug'     => 'dallas',
            ':email'    => 'dallas@example.com',
            ':password' => 'dallas123',
        ];

        $query = 'INSERT INTO users (name, slug, email, password, created_at)
			VALUES (:name, :slug, :email, :password, NOW())';

        $this->db->execute($query, $params);
    }

    /**
     * @return User
     */
    private function buildUser(): User
    {
        $user = new User();

        return $user->create(
            'Dallas',
            'dallas',
            'dallas@example.com',
            'dallas123'
        );
    }
}
