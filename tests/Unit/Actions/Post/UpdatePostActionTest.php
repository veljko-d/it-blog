<?php

namespace Tests\Unit\Actions\Post;

use App\Actions\Post\GetPostAction;
use App\Actions\Post\UpdatePostAction;
use App\Actions\Tag\StoreTagsAction;
use App\Core\Request\Request;
use App\Utils\Slug\Slug;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\Actions\PostActionTestCase;

/**
 * Class UpdatePostActionTest
 *
 * @package Tests\Unit\Actions\Post
 */
class UpdatePostActionTest extends PostActionTestCase
{
    /**
     * @var GetPostAction|MockObject
     */
    private $getPostAction;

    /**
     * @var StoreTagsAction|MockObject
     */
    private $storeTagsAction;

    /**
     * @var MockObject
     */
    private $slug;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->getPostAction = $this->createMock(GetPostAction::class);
        $this->storeTagsAction = $this->createMock(StoreTagsAction::class);
        $this->slug = $this->createMock(Slug::class);
    }

    /**
     * @return UpdatePostAction
     */
    private function getUpdatePostAction(): UpdatePostAction
    {
        return new UpdatePostAction(
            $this->logger,
            $this->postModel,
            $this->post,
            $this->getPostAction,
            $this->storeTagsAction,
            $this->slug
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function testUpdatePostValidationFail()
    {
        $updatePostAction = $this->getUpdatePostAction();
        $request = $this->createMock(Request::class);

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('title'))
            ->will($this->returnValue(['errors' => []]));

        $slug = 'new-title';

        $this->getPostAction->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($slug))
            ->will($this->returnValue(['post' => []]));

        $result = $updatePostAction->execute($request, $slug);

        $this->assertArrayHasKey('errors', $result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testUpdatePost()
    {
        $updatePostAction = $this->getUpdatePostAction();
        $post = $this->updatePost($this->buildPost());
        $request = $this->createMock(Request::class);

        $inputs = [
            'title'       => 'New Title',
            'source'      => 'www.new-source.com',
            'content'     => 'New Content content content',
            'category_id' => 6,
            'tags'        => 'Tag 5|Tag 6|Tag 7',
        ];

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('title'))
            ->will($this->returnValue(['inputs' => $inputs]));

        $slug = 'new-title';

        $this->slug->expects($this->once())
            ->method('getSlug')
            ->with($this->equalTo('New Title'))
            ->will($this->returnValue($slug));

        $this->post->expects($this->once())
            ->method('update')
            ->with(
                $this->equalTo($inputs['title']),
                $this->equalTo($slug),
                $this->equalTo($inputs['content']),
                $this->equalTo($inputs['source']),
                $this->equalTo($inputs['category_id'])
            )
            ->will($this->returnValue($post));

        $this->postModel->expects($this->once())
            ->method('update')
            ->with(
                $this->equalTo($post),
                $this->equalTo($slug)
            )
            ->will($this->returnValue($post));

        $this->storeTagsAction->expects($this->once())
            ->method('execute')
            ->with(
                $this->equalTo($inputs['tags']),
                $this->equalTo($post->getId())
            );

        $result = $updatePostAction->execute($request, $slug);

        $this->assertArrayHasKey('post', $result);
    }
}
