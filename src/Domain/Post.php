<?php

namespace App\Domain;

/**
 * Class Post
 *
 * @package App\Domain
 */
class Post
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $source;

    /**
     * @var int
     */
    private $category_id;

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
     * @var array
     */
    private $tags;

    /**
     * @var array
     */
    private $images;

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
    public function getTitle(): string
    {
        return $this->title;
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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
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
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param string $title
     * @param string $slug
     * @param string $content
     * @param string $source
     * @param int    $categoryId
     * @param int    $userId
     *
     * @return Post
     */
    public function create(
        string $title,
        string $slug,
        string $content,
        string $source,
        int $categoryId,
        int $userId
    ): Post {
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->source = $source;
        $this->category_id = $categoryId;
        $this->user_id = $userId;

        return $this;
    }

    /**
     * @param string $title
     * @param string $slug
     * @param string $content
     * @param string $source
     * @param int    $categoryId
     *
     * @return Post
     */
    public function update(
        string $title,
        string $slug,
        string $content,
        string $source,
        int $categoryId
    ): Post {
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->source = $source;
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }
}
