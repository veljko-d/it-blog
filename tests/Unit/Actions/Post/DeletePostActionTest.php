<?php

namespace Tests\Unit\Actions\Post;

use App\Actions\Post\DeletePostAction;
use App\Exceptions\DbException;
use Tests\Unit\Actions\PostActionTestCase;

/**
 * Class DeletePostActionTest
 *
 * @package Tests\Unit\Actions\Post
 */
class DeletePostActionTest extends PostActionTestCase
{
    /**
     * @return DeletePostAction
     */
    private function getDeletePostAction(): DeletePostAction
    {
        return new DeletePostAction(
            $this->logger,
            $this->postModel,
            $this->post
        );
    }

    /**
     * @test
     */
    public function testDeleteError()
    {
        $deletePostAction = $this->getDeletePostAction();

        $this->postModel->expects($this->once())
            ->method('delete')
            ->with($this->equalTo('title-title'))
            ->will($this->throwException(new DbException()));

        $result = $deletePostAction->execute('title-title');

        $this->assertArrayHasKey('message', $result);
    }

    /**
     * @test
     */
    public function testDelete()
    {
        $deletePostAction = $this->getDeletePostAction();

        $this->postModel->expects($this->once())
            ->method('delete')
            ->with($this->equalTo('title-title'));

        $result = $deletePostAction->execute('title-title');

        $this->assertArrayHasKey('status', $result);
    }
}
