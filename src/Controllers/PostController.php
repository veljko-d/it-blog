<?php

namespace App\Controllers;

use App\Actions\Post\DeletePostAction;
use App\Actions\Post\GetAllPostsAction;
use App\Actions\Post\GetPostAction;

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
