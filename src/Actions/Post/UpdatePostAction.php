<?php

namespace App\Actions\Post;

use App\Actions\Category\GetParentCategoriesAction;
use App\Actions\Tag\StoreTagsAction;
use App\Core\Loggers\LoggerInterface;
use App\Core\Request\Request;
use App\Domain\Post;
use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Models\Post\PostModelInterface;
use App\Utils\Slug\Slug;

/**
 * Class UpdatePostAction
 *
 * @package App\Actions\Post
 */
class UpdatePostAction extends AbstractPostAction
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
    ];

    /**
     * @var GetPostAction
     */
    private $getPostAction;

    /**
     * @var StoreTagsAction
     */
    private $storeTagsAction;

    /**
     * @var GetParentCategoriesAction
     */
    private $getParentCategoriesAction;

    /**
     * @var Slug
     */
    private $slug;

    /**
     * UpdatePostAction constructor.
     *
     * @param LoggerInterface           $logger
     * @param PostModelInterface        $postModel
     * @param Post                      $post
     * @param GetPostAction             $getPostAction
     * @param StoreTagsAction           $storeTagsAction
     * @param GetParentCategoriesAction $getParentCategoriesAction
     * @param Slug                      $slug
     */
    public function __construct(
        LoggerInterface $logger,
        PostModelInterface $postModel,
        Post $post,
        GetPostAction $getPostAction,
        StoreTagsAction $storeTagsAction,
        GetParentCategoriesAction $getParentCategoriesAction,
        Slug $slug
    ) {
        parent::__construct($logger, $postModel, $post);

        $this->storeTagsAction = $storeTagsAction;
        $this->getPostAction = $getPostAction;
        $this->getParentCategoriesAction = $getParentCategoriesAction;
        $this->slug = $slug;
        $this->slug->setModel($this->postModel);
    }

    /**
     * @param Request $request
     * @param string  $slug
     *
     * @return array|\string[][]
     * @throws \ReflectionException
     */
    public function execute(Request $request, string $slug)
    {
        try {
            $data = $request->validate($this->validationFields);
        } catch (NotFoundException $e) {
            die($e->getMessage());
        }

        if (isset($data['errors'])) {
            $categories = $this->getParentCategoriesAction->execute();
            $post = $this->getPostAction->execute($slug);

            return [
                'post'       => $post['post'],
                'categories' => $categories['categories'],
                'errors'     => $data['errors'],
            ];
        }

        try {
            return $this->update($data['inputs'], $slug);
        } catch (DbException $e) {
            $this->logger->error('Error: ' . $e->getMessage());
            return ['errors' => ['errors' => 'Error: failed to update post']];
        } catch (NotFoundException $e) {
            $this->logger->warning('Error: ' . $e->getMessage());
            return ['errors' => ['errors' => 'Error: ' . $e->getMessage()]];
        }
    }

    /**
     * @param array  $inputs
     * @param string $slug
     *
     * @return array
     * @throws DbException
     * @throws NotFoundException
     */
    private function update(array $inputs, string $slug): array
    {
        $postInstance = $this->updatePost($inputs);
        $post = $this->postModel->update($postInstance, $slug);

        $this->storeTagsAction->execute($inputs['tags'], $post->getId());

        return [
            'post'   => $post->getSlug(),
            'status' => 'Post successfully updated!',
        ];
    }

    /**
     * @param array $inputs
     *
     * @return Post
     */
    private function updatePost(array $inputs): Post
    {
        return $this->post->update(
            $inputs['title'],
            $this->slug->getSlug($inputs['title']),
            $inputs['content'],
            $inputs['source'],
            $inputs['category_id']
        );
    }
}
