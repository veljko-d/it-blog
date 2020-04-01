<?php

namespace App\Domain;

/**
 * Class User
 *
 * @package App\Domain
 */
class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $email_verified_at;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getEmailVerifiedAt(): string
    {
        return $this->email_verified_at;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $name
     * @param string $slug
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public function create(
        string $name,
        string $slug,
        string $email,
        string $password
    ): User {
        $this->name = $name;
        $this->slug = $slug;
        $this->email = $email;
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $emailVerifiedAt
     */
    public function setEmailVerifiedAt(string $emailVerifiedAt): void
    {
        $this->email_verified_at = $emailVerifiedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updated_at = $updatedAt;
    }
}
