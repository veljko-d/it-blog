<?php

namespace Tests\Unit\Actions;

use App\Core\Loggers\MonologDriver;
use App\Domain\Post;
use App\Models\Post\PostModel;
use ReflectionClass;
use Tests\AbstractTestCase;

/**
 * Class PostActionTestCase
 *
 * @package Tests\Unit\Actions
 */
abstract class PostActionTestCase extends AbstractTestCase
{
    /**
     * @var
     */
    protected $logger;

    /**
     * @var
     */
    protected $postModel;

    /**
     * @var
     */
    protected $post;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        $this->logger = $this->createMock(MonologDriver::class);
        $this->postModel = $this->createMock(PostModel::class);
        $this->post = $this->createMock(Post::class);
    }

    /**
     * @return Post
     * @throws \ReflectionException
     */
    protected function buildPost(): Post
    {
        $post = new Post();

        $reflectionClass = new ReflectionClass(Post::class );

        $id = $reflectionClass->getProperty('id');
        $id->setAccessible(true);
        $id->setValue($post, 1);

        return $post;
    }
}
