<?php

namespace App\Controllers;

use App\Actions\Category\GetPostsByCategoryAction;

/**
 * Class CategoryController
 *
 * @package App\Controllers
 */
class CategoryController extends AbstractController
{
    /**
     * @param string                   $slug
     * @param GetPostsByCategoryAction $getPostsByCategoryAction
     *
     * @return string
     */
    public function index(
        string $slug,
        GetPostsByCategoryAction $getPostsByCategoryAction
    ) {
        $params = $getPostsByCategoryAction->execute($this->request, $slug);

        return $this->render('posts/index', $params);
    }
}
