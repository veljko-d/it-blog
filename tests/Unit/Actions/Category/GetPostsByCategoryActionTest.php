<?php

namespace Tests\Unit\Actions\Category;

use App\Actions\Category\GetPostsByCategoryAction;
use App\Core\Request\Request;
use Tests\Unit\Actions\CategoryActionTestCase;

/**
 * Class GetPostsByCategoryActionTest
 *
 * @package Tests\Unit\Actions\Category
 */
class GetPostsByCategoryActionTest extends CategoryActionTestCase
{
    /**
     * @return GetPostsByCategoryAction
     */
    private function getGetPostsByCategoryAction(): GetPostsByCategoryAction
    {
        return new GetPostsByCategoryAction(
            $this->logger,
            $this->categoryModel,
            $this->category
        );
    }

    /**
     * @test
     */
    public function testGetPostsByCategory()
    {
        $getPostsByCategoryAction = $this->getGetPostsByCategoryAction();

        $request = $this->createMock(Request::class);

        $this->categoryModel->expects($this->once())
            ->method('getPostsByCategory')
            ->with($this->arrayHasKey('page'))
            ->will($this->returnValue([]));

        $result = $getPostsByCategoryAction->execute($request, 'Cat 1');

        $this->assertArrayHasKey('posts', $result);
    }
}
