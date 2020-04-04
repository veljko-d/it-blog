<?php

namespace App\Actions\Post;

use App\Core\Request\Request;
use App\Exceptions\DbException;

/**
 * Class GetAllPostsAction
 *
 * @package App\Actions\Post
 */
class GetAllPostsAction extends AbstractPostAction
{
    /**
     * @const
     */
    const PAGE_LENGTH = 5;

    /**
     * @param Request $request
     *
     * @return array
     */
    public function execute(Request $request): array
    {
        $params = [
            'page'   => $request->getQueryParams()->page(),
            'length' => $this::PAGE_LENGTH,
            'search' => $request->getQueryParams()->search(),
        ];

        try {
            return $this->getAll($params);
        } catch (DbException $e) {
            $this->logger->error('Error: ' . $e->getMessage());
            die('Error: ' . $e->getMessage()); // temporary solution
        }
    }

    /**
     * @param $params
     *
     * @return array
     */
    private function getAll($params): array
    {
        $posts = $this->postModel->getAll($params);
        $pagination = $this->pagination($params['search']);

        return [
            'posts'       => $posts,
            'pagesArray'  => $pagination,
            'currentPage' => $params['page'],
            'lastPage'    => end($pagination),
        ];
    }

    /**
     * @param string $search
     *
     * @return array
     */
    private function pagination(string $search): array
    {
        $numberOfPosts = $this->postModel->count($search);
        $numberOfPages = ceil($numberOfPosts / self::PAGE_LENGTH);
        $pagination = [];

        for ($x = 1; $x <= $numberOfPages; $x++) {
            $pagination[$x] = $x;
        }

        return $pagination;
    }
}
