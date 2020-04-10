<?php

namespace App\Actions\Post;

use App\Actions\Image\GetImagesByPostAction;
use App\Actions\Tag\GetTagsByPostAction;
use App\Core\Loggers\LoggerInterface;
use App\Domain\Post;
use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Models\Post\PostModelInterface;

/**
 * Class GetPostAction
 *
 * @package App\Actions\Post
 */
class GetPostAction extends AbstractPostAction
{
    /**
     * @var GetTagsByPostAction
     */
    private $getTagsByPostAction;

    /**
     * @var GetImagesByPostAction
     */
    private $getImagesByPostAction;

    /**
     * GetPostAction constructor.
     *
     * @param LoggerInterface       $logger
     * @param PostModelInterface    $postModel
     * @param Post                  $post
     * @param GetTagsByPostAction   $getTagsByPostAction
     * @param GetImagesByPostAction $getImagesByPostAction
     */
    public function __construct(
        LoggerInterface $logger,
        PostModelInterface $postModel,
        Post $post,
        GetTagsByPostAction $getTagsByPostAction,
        GetImagesByPostAction $getImagesByPostAction
    ) {
        parent::__construct($logger, $postModel, $post);

        $this->getTagsByPostAction = $getTagsByPostAction;
        $this->getImagesByPostAction = $getImagesByPostAction;
    }

    /**
     * @param string $slug
     *
     * @return array
     */
    public function execute(string $slug): array
    {
        try {
            return ['post' => $this->getPost($slug)];
        } catch (DbException $e) {
            $this->logger->error('Error getting post: ' . $e->getMessage());
            return ['message' => 'Error getting post'];
        } catch (NotFoundException $e) {
            return ['message' => 'Post not found'];
        }
    }

    /**
     * @param string $slug
     *
     * @return Post
     */
    private function getPost(string $slug): Post
    {
        $post = $this->postModel->get($slug);

        $tags = $this->getTagsByPostAction->execute($post->getId());
        $post->setTags($tags);

        $images = $this->getImagesByPostAction->execute($post->getId());
        $post->setImages($images);

        return $post;
    }
}
