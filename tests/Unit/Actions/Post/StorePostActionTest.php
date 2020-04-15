<?php

namespace Tests\Unit\Actions\Post;

use App\Actions\Image\StoreImageAction;
use App\Actions\Post\StorePostAction;
use App\Actions\Tag\StoreTagsAction;
use App\Core\Request\Request;
use App\Utils\Slug\Slug;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\Actions\PostActionTestCase;

/**
 * Class StorePostActionTest
 *
 * @package Tests\Unit\Actions\Post
 */
class StorePostActionTest extends PostActionTestCase
{
    /**
     * @var StoreTagsAction|MockObject
     */
    private $storeTagsAction;

    /**
     * @var StoreImageAction|MockObject
     */
    private $storeImageAction;

    /**
     * @var Slug|MockObject
     */
    private $slug;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->storeTagsAction = $this->createMock(StoreTagsAction::class);
        $this->storeImageAction = $this->createMock(StoreImageAction::class);
        $this->slug = $this->createMock(Slug::class);
    }

    /**
     * @return StorePostAction
     */
    private function getStorePostAction(): StorePostAction
    {
        return new StorePostAction(
            $this->logger,
            $this->postModel,
            $this->post,
            $this->storeTagsAction,
            $this->storeImageAction,
            $this->slug
        );
    }

    /**
     * @test
     */
    public function testStorePostValidationFail()
    {
        $storePostAction = $this->getStorePostAction();
        $request = $this->createMock(Request::class);

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('title'))
            ->will($this->returnValue(['errors' => []]));

        $this->postModel->expects($this->never())
            ->method('store');

        $result = $storePostAction->execute($request, 1);

        $this->assertArrayHasKey('errors', $result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testStorePost()
    {
        $storePostAction = $this->getStorePostAction();
        $post = $this->buildPost();
        $request = $this->createMock(Request::class);

        $inputs = [
            'title'       => 'Title Title',
            'source'      => 'www.source.com',
            'content'     => 'Content content content',
            'category_id' => 4,
            'tags'        => 'Tag 1|Tag 2|Tag 3',
            'images'      => [0 => [], 1 => [], 2 => []],
        ];

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('title'))
            ->will($this->returnValue(['inputs' => $inputs]));

        $slug = 'title-title';
        $userId = 3;

        $this->slug->expects($this->once())
            ->method('getSlug')
            ->with($this->equalTo('Title Title'))
            ->will($this->returnValue($slug));

        $this->post->expects($this->once())
            ->method('create')
            ->with(
                $this->equalTo($inputs['title']),
                $this->equalTo($slug),
                $this->equalTo($inputs['content']),
                $this->equalTo($inputs['source']),
                $this->equalTo($inputs['category_id']),
                $this->equalTo($userId)
            )
            ->will($this->returnValue($post));

        $this->postModel->expects($this->once())
            ->method('store')
            ->with($post)
            ->will($this->returnValue($post));

        $this->storeTagsAction->expects($this->once())
            ->method('execute')
            ->with($this->equalTo(
                $inputs['tags']),
                $post->getId()
            );

        $this->storeImageAction->expects($this->once())
            ->method('execute')
            ->with($this->equalTo(
                $inputs['images']),
                $post->getId()
            );

        $result = $storePostAction->execute($request, $userId);

        $this->assertArrayHasKey('post', $result);
    }
}
