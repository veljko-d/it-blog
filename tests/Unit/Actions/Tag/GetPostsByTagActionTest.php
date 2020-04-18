<?php

namespace Tests\Unit\Actions\Tag;

use App\Actions\Tag\GetPostsByTagAction;
use App\Core\Request\Request;
use Tests\Unit\Actions\TagActionTestCase;

/**
 * Class GetPostsByTagActionTest
 *
 * @package Tests\Unit\Actions\Tag
 */
class GetPostsByTagActionTest extends TagActionTestCase
{
    /**
     * @return GetPostsByTagAction
     */
    private function getGetPostsByTagAction(): GetPostsByTagAction
    {
        return new GetPostsByTagAction($this->logger, $this->tagModel, $this->tag);
    }

    /**
     * @test
     */
    public function testGetPostsByTag()
    {
        $getPostsByTagAction = $this->getGetPostsByTagAction();

        $request = $this->createMock(Request::class);

        $this->tagModel->expects($this->once())
            ->method('getPostsByTag')
            ->with($this->arrayHasKey('page'))
            ->will($this->returnValue([]));

        $result = $getPostsByTagAction->execute($request, 'tag-name');

        $this->assertArrayHasKey('posts', $result);
    }
}
