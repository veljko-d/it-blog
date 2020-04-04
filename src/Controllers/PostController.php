<?php

namespace App\Controllers;

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
}
