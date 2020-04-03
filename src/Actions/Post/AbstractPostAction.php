<?php

namespace App\Actions\Post;

use App\Core\Loggers\LoggerInterface;
use App\Models\Post\PostModelInterface;
use App\Domain\Post;

/**
 * Class AbstractPostAction
 *
 * @package App\Actions\Post
 */
abstract class AbstractPostAction
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var PostModelInterface
     */
    protected $postModel;

    /**
     * @var Post
     */
    protected $post;

    /**
     * AbstractPostAction constructor.
     *
     * @param LoggerInterface    $logger
     * @param PostModelInterface $postModel
     * @param Post               $post
     */
    public function __construct(
        LoggerInterface $logger,
        PostModelInterface $postModel,
        Post $post
    ) {
        $this->logger = $logger;
        $this->postModel = $postModel;
        $this->post = $post;
    }
}
