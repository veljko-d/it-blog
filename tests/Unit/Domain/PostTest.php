<?php

namespace Tests\Unit\Domain;

use Tests\AbstractTestCase;
use App\Domain\Post;

/**
 * Class PostTest
 *
 * @package Tests\Unit\Domain
 */
class PostTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testClassInstance()
    {
        $post = new Post();

        $this->assertInstanceOf(
            Post::class,
            $post,
            'Created object is not the instance of the Post class.'
        );
    }

    /**
     * @test
     */
    public function testGetData()
    {
        $post = $this->buildPost();

        $this->assertSame(
            'Title Title',
            $post->getTitle(),
            'Title is incorrect.'
        );

        $this->assertSame(
            'title-title',
            $post->getSlug(),
            'Slug is incorrect.'
        );

        $this->assertSame(
            'Content Content Content',
            $post->getContent(),
            'Content is incorrect.'
        );

        $this->assertSame(
            'www.source.com',
            $post->getSource(),
            'Source is incorrect.'
        );

        $this->assertSame(
            2,
            $post->getCategoryId(),
            'User ID is incorrect.'
        );

        $this->assertSame(
            3,
            $post->getUserId(),
            'User ID is incorrect.'
        );
    }

    /**
     * @test
     */
    public function testUpdatePost()
    {
        $post = $this->buildPost();

        $post = $post->update(
            'New Title',
            'new-title',
            'New Content',
            'www.new-source.com',
            4
        );

        $this->assertSame(
            'New Title',
            $post->getTitle(),
            'Title is incorrect.'
        );

        $this->assertSame(
            'new-title',
            $post->getSlug(),
            'Slug is incorrect.'
        );

        $this->assertSame(
            'New Content',
            $post->getContent(),
            'Content is incorrect.'
        );

        $this->assertSame(
            'www.new-source.com',
            $post->getSource(),
            'Source is incorrect.'
        );

        $this->assertSame(
            4,
            $post->getCategoryId(),
            'User ID is incorrect.'
        );
    }

    /**
     * @test
     */
    public function testSetTagsAndGetTags()
    {
        $post = new Post();

        $tags = ['one','two', 'three'];

        $post->setTags($tags);

        $this->assertSame(
            $tags,
            $post->getTags(),
            'Tags are incorrect.'
        );
    }

    /**
     * @test
     */
    public function testSetImagesAndGetImages()
    {
        $post = new Post();

        $images = ['one','two', 'three'];

        $post->setImages($images);

        $this->assertSame(
            $images,
            $post->getImages(),
            'Images are incorrect.'
        );
    }

    /**
     * @return Post
     */
    private function buildPost(): Post
    {
        $post = new Post;

        return $post->create(
            'Title Title',
            'title-title',
            'Content Content Content',
            'www.source.com',
            2,
            3
        );
    }
}
