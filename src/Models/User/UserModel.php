<?php

namespace App\Models\User;

use App\Models\AbstractModel;
use App\Domain\User;
use PDO;
use PDOException;
use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;

/**
 * Class UserModel
 *
 * @package App\Models\User
 */
class UserModel extends AbstractModel implements UserModelInterface
{
    /**
     * @const
     */
    const CLASSNAME = User::class;

    /**
     * @param User $user
     *
     * @return mixed|void
     * @throws DbException
     */
    public function store(User $user)
    {
        $query = 'INSERT INTO users (name, slug, email, password, created_at)
			VALUES (:name, :slug, :email, :password, NOW())';

        $bindParams = [
            ':name'     => $user->getName(),
            ':slug'     => $user->getSlug(),
            ':email'    => $user->getEmail(),
            ':password' => $user->getPassword(),
        ];

        try {
            $this->db->execute($query, $bindParams);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    /**
     * @param string $slug
     * @param string $email
     *
     * @return User
     * @throws DbException
     * @throws NotFoundException
     */
    public function get(string $slug, string $email = ""): User
    {
        $query = 'SELECT *
            FROM users
            WHERE slug = :slug OR email = :email';

        try {
            $user = $this->db->fetchAll(
                $query,
                [':slug' => $slug, ':email' => $email],
                PDO::FETCH_CLASS,
                self::CLASSNAME
            );
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }

        if (empty($user)) {
            throw new NotFoundException('User not found.');
        }

        return $user[0];
    }

    /**
     * @param string $slug
     *
     * @return mixed|void
     * @throws DbException
     */
    public function delete(string $slug)
    {
        $query = 'DELETE FROM users WHERE slug = :slug';

        try {
            $this->db->execute($query, [':slug' => $slug]);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
}
