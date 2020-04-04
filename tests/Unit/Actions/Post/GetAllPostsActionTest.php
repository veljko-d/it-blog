<?php

namespace Tests\Unit\Actions\Post;

use App\Actions\Post\GetAllPostsAction;
use App\Core\Request\Request;
use Tests\Unit\Actions\PostActionTestCase;

/**
 * Class GetAllPostsActionTest
 *
 * @package Tests\Unit\Actions\Post
 */
class GetAllPostsActionTest extends PostActionTestCase
{
    /**
     * @return GetAllPostsAction
     */
    public function getGetAllPostsAction(): GetAllPostsAction
    {
        return new GetAllPostsAction(
            $this->logger,
            $this->postModel,
            $this->post
        );
    }

    /**
     * @test
     */
    public function testGetAllPosts()
    {
        $getAllPostsAction = $this->getGetAllPostsAction();

        $request = $this->createMock(Request::class);

        $this->postModel->expects($this->once())
            ->method('getAll')
            ->with($this->arrayHasKey('page'))
            ->will($this->returnValue([]));

        $result = $getAllPostsAction->execute($request);

        $this->assertArrayHasKey('posts', $result);
    }
}
