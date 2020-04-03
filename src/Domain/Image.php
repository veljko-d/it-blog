<?php

namespace App\Domain;

/**
 * Class Image
 *
 * @package App\Domain
 */
class Image
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
    private $ext;

    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $user_id;

    /**
     * @var int
     */
    private $post_id;

    /**
     * @var int
     */
    private $category_id;

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
    public function getExt(): string
    {
        return $this->ext;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getPostId(): string
    {
        return $this->post_id;
    }

    /**
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->category_id;
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
     * @param string $ext
     * @param string $path
     * @param int    $size
     *
     * @return Image
     */
    public function create(
        string $name,
        string $ext,
        string $path,
        int $size
    ): Image {
        $this->name = $name;
        $this->ext = $ext;
        $this->path = $path;
        $this->size = $size;

        return $this;
    }

    /**
     * @param int $postId
     */
    public function setPostId(int $postId): void
    {
        $this->post_id = $postId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->category_id = $categoryId;
    }
}
