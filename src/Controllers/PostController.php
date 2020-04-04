<?php

namespace App\Controllers;

use App\Actions\Post\DeletePostAction;
use App\Actions\Post\GetAllPostsAction;

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
