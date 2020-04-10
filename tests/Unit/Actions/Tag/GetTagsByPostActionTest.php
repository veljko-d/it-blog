<?php

namespace Tests\Unit\Actions\Tag;

use App\Actions\Tag\GetTagsByPostAction;
use Tests\Unit\Actions\TagActionTestCase;

/**
 * Class GetTagsByPostActionTest
 *
 * @package Tests\Unit\Actions\Tag
 */
class GetTagsByPostActionTest extends TagActionTestCase
{
    /**
     * @return GetTagsByPostAction
     */
    private function getGetTagsByPostAction(): GetTagsByPostAction
    {
        return new GetTagsByPostAction($this->logger, $this->tagModel, $this->tag);
    }

    /**
     * @test
     */
    public function testGetTagsByPost()
    {
        $getTagsByPostAction = $this->getGetTagsByPostAction();

        $tags = ['tag_1' => 'Tag-1', 'tag_2' => 'Tag-2'];

        $this->tagModel->expects($this->once())
            ->method('getByPost')
            ->with(3)
            ->will($this->returnValue($tags));

        $result = $getTagsByPostAction->execute(3);

        $this->assertSame($result, $tags);
    }
}
