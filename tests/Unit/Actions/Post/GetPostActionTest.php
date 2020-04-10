<?php

namespace Tests\Unit\Actions\Post;

use App\Actions\Image\GetImagesByPostAction;
use App\Actions\Post\GetPostAction;
use App\Actions\Tag\GetTagsByPostAction;
use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\Actions\PostActionTestCase;

/**
 * Class GetPostActionTest
 *
 * @package Tests\Unit\Actions\Post
 */
class GetPostActionTest extends PostActionTestCase
{
    /**
     * @var GetTagsByPostAction|MockObject
     */
    private $getTagsByPostAction;

    /**
     * @var GetImagesByPostAction|MockObject
     */
    private $getImagesByPostAction;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->getTagsByPostAction = $this->createMock(GetTagsByPostAction::class);
        $this->getImagesByPostAction = $this->createMock(GetImagesByPostAction::class);
    }

    /**
     * @return GetPostAction
     */
    private function getGetPostAction(): GetPostAction
    {
        return new GetPostAction(
            $this->logger,
            $this->postModel,
            $this->post,
            $this->getTagsByPostAction,
            $this->getImagesByPostAction
        );
    }

    /**
     * @test
     */
    public function testGetPostNotFound()
    {
        $getPostAction = $this->getGetPostAction();

        $this->postModel->expects($this->once())
            ->method('get')
            ->with('title-title')
            ->will($this->throwException(new NotFoundException()));

        $result = $getPostAction->execute('title-title');

        $this->assertArrayHasKey('message', $result);
    }

    /**
     * @test
     */
    public function testGetPostDbError()
    {
        $getPostAction = $this->getGetPostAction();

        $this->postModel->expects($this->once())
            ->method('get')
            ->with('title-title')
            ->will($this->throwException(new DbException()));

        $result = $getPostAction->execute('title-title');

        $this->assertArrayHasKey('message', $result);
    }

    /**
     * @test
     */
    public function testGetPost()
    {
        $getPostAction = $this->getGetPostAction();
        $post = $this->buildPost();

        $this->postModel->expects($this->once())
            ->method('get')
            ->with('title-title')
            ->will($this->returnValue($post));

        $this->getTagsByPostAction->expects($this->once())
            ->method('execute')
            ->with($post->getId())
            ->will($this->returnValue([]));

        $this->getImagesByPostAction->expects($this->once())
            ->method('execute')
            ->with($post->getId())
            ->will($this->returnValue([]));

        $result = $getPostAction->execute('title-title');

        $this->assertArrayHasKey('post', $result);
    }
}
