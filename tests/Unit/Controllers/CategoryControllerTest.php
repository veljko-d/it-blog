<?php

namespace Tests\Unit\Controllers;

use App\Actions\Category\GetPostsByCategoryAction;
use App\Controllers\CategoryController;
use Tests\Unit\ControllerTestCase;

/**
 * Class CategoryControllerTest
 *
 * @package Tests\Unit\Controllers
 */
class CategoryControllerTest extends ControllerTestCase
{
    /**
     * @return CategoryController
     */
    private function getCategoryController(): CategoryController
    {
        return new CategoryController(
            $this->request,
            $this->redirect,
            $this->sessionManager,
            $this->templateEngine
        );
    }

    /**
     * @test
     */
    public function testGetPostsByCategory()
    {
        $categoryController = $this->getCategoryController();

        $getPostsByCategoryAction = $this->createMock(GetPostsByCategoryAction::class);

        $slug = 'cat-5';

        $getPostsByCategoryAction->expects($this->once())
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

        $result = $categoryController->index($slug, $getPostsByCategoryAction);

        $this->assertSame(
            $result,
            $response,
            'Response object is not the expected one.'
        );
    }
}
