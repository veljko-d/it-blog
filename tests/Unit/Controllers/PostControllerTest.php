<?php

namespace Tests\Unit\Controllers;

use App\Actions\Post\GetAllPostsAction;
use App\Controllers\PostController;
use Tests\Unit\ControllerTestCase;

/**
 * Class PostControllerTest
 *
 * @package Tests\Unit\Controllers
 */
class PostControllerTest extends ControllerTestCase
{
    /**
     * @return PostController
     */
    private function getController(): PostController
    {
        return new PostController(
            $this->request,
            $this->redirect,
            $this->sessionManager,
            $this->templateEngine
        );
    }

    /**
     * @test
     */
    public function testGetAll()
    {
        $controller = $this->getController();

        $getAllPostsAction = $this->createMock(GetAllPostsAction::class);

        $getAllPostsAction->expects($this->once())
            ->method('execute')
            ->with($this->request)
            ->will($this->returnValue(['posts' => []]));

        $response = "Rendered template";

        $this->templateEngine->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('posts/index'),
                $this->arrayHasKey('posts')
            )
            ->will($this->returnValue($response));

        $result = $controller->index($getAllPostsAction);

        $this->assertSame(
            $result,
            $response,
            'Response object is not the expected one.'
        );
    }
}
