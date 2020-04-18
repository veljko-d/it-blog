<?php

namespace Tests\Unit\Controllers;

use App\Actions\Tag\GetPostsByTagAction;
use App\Controllers\TagController;
use Tests\Unit\ControllerTestCase;

/**
 * Class TagControllerTest
 *
 * @package Tests\Unit\Controllers
 */
class TagControllerTest extends ControllerTestCase
{
    /**
     * @return TagController
     */
    private function getTagController(): TagController
    {
        return new TagController(
            $this->request,
            $this->redirect,
            $this->sessionManager,
            $this->templateEngine
        );
    }

    /**
     * @test
     */
    public function testGetPostsByTag()
    {
        $tagController = $this->getTagController();

        $getPostsByTagAction = $this->createMock(GetPostsByTagAction::class);

        $slug = 'tag-name';

        $getPostsByTagAction->expects($this->once())
        ->method('execute')
        ->with(
            $this->equalTo($this->request),
            $this->equalTo($slug)
        )
        ->will($this->returnValue(['posts' => []]));

        $response = "Rendered template";

        $this->templateEngine->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('posts/index'),
                $this->arrayHasKey('posts')
            )
            ->will($this->returnValue($response));

        $result = $tagController->index($slug, $getPostsByTagAction);

        $this->assertSame(
            $result,
            $response,
            'Response object is not the expected one.'
        );
    }
}
