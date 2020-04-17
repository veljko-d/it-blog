<?php

namespace App\Controllers;

use App\Actions\Category\GetParentCategoriesAction;
use App\Actions\Post\DeletePostAction;
use App\Actions\Post\GetAllPostsAction;
use App\Actions\Post\GetPostAction;
use App\Actions\Post\StorePostAction;

/**
 * Class PostController
 *
 * @package App\Controllers
 */
class PostController extends AbstractController
{
    /**
     * @param GetAllPostsAction $getAllPostsAction
     *
     * @return string
     */
    public function index(GetAllPostsAction $getAllPostsAction): string
    {
        $params = $getAllPostsAction->execute($this->request);

        return $this->render('posts/index', $params);
    }

    /**
     * @param GetParentCategoriesAction $getParentCategoriesAction
     *
     * @return string
     */
    public function create(GetParentCategoriesAction $getParentCategoriesAction): string
    {
        $params = $getParentCategoriesAction->execute();

        return $this->render('posts/create', $params);
    }

    /**
     * @param StorePostAction $storePostAction
     *
     * @return string
     */
    public function store(StorePostAction $storePostAction)
    {
        $params = $storePostAction->execute($this->request, $this->userId);

        if (isset($params['errors'])) {
            return $this->render('posts/create', $params);
        }

        $this->setStatusMessage('status', $params['status']);
        $this->redirect->location('/posts/' . $params['post']);
    }

    /**
     * @param string        $slug
     * @param GetPostAction $getPostAction
     *
     * @return string
     */
    public function show(string $slug, GetPostAction $getPostAction): string
    {
        $params = $getPostAction->execute($slug);

        $template = isset($params['message']) ? 'not-found' : 'posts/show';

        return $this->render($template, $params);
    }

    /**
     * @param string                    $slug
     * @param GetPostAction             $getPostAction
     * @param GetParentCategoriesAction $getParentCategoriesAction
     *
     * @return string
     */
    public function edit(
        string $slug,
        GetPostAction $getPostAction,
        GetParentCategoriesAction $getParentCategoriesAction
    ): string {
        $post = $getPostAction->execute($slug);
        $categories = $getParentCategoriesAction->execute();

        return $this->render('posts/edit', array_merge($post, $categories));
    }

    /**
     * @param string           $slug
     * @param DeletePostAction $deletePostAction
     *
     * @return string
     */
    public function destroy(string $slug, DeletePostAction $deletePostAction)
    {
        $params = $deletePostAction->execute($slug);

        if (isset($params['message'])) {
            return $this->render('not-found', $params);
        }

        $this->setStatusMessage('status', $params['status']);
        $this->redirect->location('/posts');
    }
}
