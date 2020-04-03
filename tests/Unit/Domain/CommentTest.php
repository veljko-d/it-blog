<?php

namespace Tests\Unit\Domain;

use Tests\AbstractTestCase;
use App\Domain\Comment;

/**
 * Class CommentTest
 *
 * @package Tests\Unit\Domain
 */
class CommentTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testClassInstance()
    {
        $comment = new Comment();

        $this->assertInstanceOf(
            Comment::class,
            $comment,
            'Created object is not the instance of the Comment class.'
        );
    }

    /**
     * @test
     */
    public function testCreateAndGetData()
    {
        $comment = $this->buildComment();

        $this->assertSame(
            'Comment Content, Comment Content.',
            $comment->getContent(),
            'Content is incorrect.'
        );

        $this->assertSame(
            10,
            $comment->getPostId(),
            'Post ID is incorrect.'
        );

        $this->assertSame(
            3,
            $comment->getUserId(),
            'User ID is incorrect.'
        );
    }

    /**
     * @return Comment
     */
    private function buildComment():Comment
    {
        $comment = new Comment;

        return $comment->create('Comment Content, Comment Content.', 10, 3);
    }
}
