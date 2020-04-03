<?php

namespace App\Domain;

/**
 * Class Comment
 *
 * @package App\Domain
 */
class Comment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $post_id;

    /**
     * @var int
     */
    private $user_id;

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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
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
     * @param string $content
     * @param int    $postId
     * @param int    $userId
     *
     * @return Comment
     */
    public function create(string $content, int $postId, int $userId): Comment
    {
        $this->content = $content;
        $this->post_id = $postId;
        $this->user_id = $userId;

        return $this;
    }
}
