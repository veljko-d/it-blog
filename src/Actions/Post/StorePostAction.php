<?php

namespace App\Actions\Post;

use App\Actions\Image\StoreImageAction;
use App\Actions\Tag\StoreTagsAction;
use App\Core\Loggers\LoggerInterface;
use App\Core\Request\Request;
use App\Domain\Post;
use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Models\Post\PostModelInterface;
use App\Utils\Slug\Slug;
use ReflectionException;

/**
 * Class StorePostAction
 *
 * @package App\Actions\Post
 */
class StorePostAction extends AbstractPostAction
{
    /**
     * @var array
     */
    private $validationFields = [
        'title' => [
            'required' => true,
            'min'      => 2,
            'max'      => 255,
        ],
        'source' => [
            'required' => true,
            'min'      => 6,
            'max'      => 255,
        ],
        'content' => [
            'required' => true,
            'min'      => 20,
        ],
        'category_id' => [
            'required' => true,
            'type'     => 'integer',
        ],
        'tags' => [
            'required' => false,
            'max'      => 255,
        ],
        'images' => [
            'required' => false,
            'type'     => 'image',
            'ext'      => 'jpg,jpeg,bmp,png,webp,gif',
            'size'     => 75000,
        ],
    ];

    /**
     * @var StoreTagsAction
     */
    private $storeTagsAction;

    /**
     * @var StoreImageAction
     */
    private $storeImageAction;

    /**
     * @var Slug
     */
    private $slug;

    /**
     * StorePostAction constructor.
     *
     * @param LoggerInterface    $logger
     * @param PostModelInterface $postModel
     * @param Post               $post
     * @param StoreTagsAction    $storeTagsAction
     * @param StoreImageAction   $storeImageAction
     * @param Slug               $slug
     */
    public function __construct(
        LoggerInterface $logger,
        PostModelInterface $postModel,
        Post $post,
        StoreTagsAction $storeTagsAction,
        StoreImageAction $storeImageAction,
        Slug $slug
    ) {
        parent::__construct($logger, $postModel, $post);

        $this->storeTagsAction = $storeTagsAction;
        $this->storeImageAction = $storeImageAction;
        $this->slug = $slug;
        $this->slug->setModel($this->postModel);
    }

    /**
     * @param Request $request
     * @param int     $userId
     *
     * @return array
     */
    public function execute(Request $request, int $userId)
    {
        try {
            $data = $request->validate($this->validationFields);
        } catch (NotFoundException | ReflectionException $e) {
            die($e->getMessage());
        }

        if (isset($data['errors'])) {
            return ['errors' => $data['errors']];
        }

        try {
            return $this->store($data['inputs'], $userId);
        } catch (DbException $e) {
            $this->logger->error('Error: ' . $e->getMessage());
            return ['errors' => ['errors' => 'Error: Failed to create Post']];
        } catch (NotFoundException $e) {
            $this->logger->warning('Error: ' . $e->getMessage());
            return ['errors' => ['errors' => 'Error: ' . $e->getMessage()]];
        }
    }

    /**
     * @param array $inputs
     * @param int   $userId
     *
     * @return array
     * @throws DbException
     * @throws NotFoundException
     */
    private function store(array $inputs, int $userId): array
    {
        $postInstance = $this->createPost($inputs, $userId);
        $post = $this->postModel->store($postInstance);

        if (!empty($inputs['tags'])) {
            $this->storeTagsAction->execute($inputs['tags'], $post->getId());
        }

        if (!empty($inputs['images'])) {
            $this->storeImageAction->execute($inputs['images'], $post->getId());
        }

        return [
            'post'   => $post->getSlug(),
            'status' => 'Post successfully created!',
        ];
    }

    /**
     * @param array $inputs
     * @param int   $userId
     *
     * @return Post
     */
    private function createPost(array $inputs, int $userId): Post
    {
        return $this->post->create(
            $inputs['title'],
            $this->slug->getSlug($inputs['title']),
            $inputs['content'],
            $inputs['source'],
            $inputs['category_id'],
            $userId
        );
    }
}
