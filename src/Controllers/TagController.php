<?php

namespace App\Controllers;

use App\Actions\Tag\GetPostsByTagAction;

/**
 * Class TagController
 *
 * @package App\Controllers
 */
class TagController extends AbstractController
{
    /**
     * @param string              $slug
     * @param GetPostsByTagAction $getPostsByTagAction
     *
     * @return string
     */
    public function index(string $slug, GetPostsByTagAction $getPostsByTagAction)
    {
        $params = $getPostsByTagAction->execute($this->request, $slug);

        return $this->render('posts/index', $params);
    }
}
