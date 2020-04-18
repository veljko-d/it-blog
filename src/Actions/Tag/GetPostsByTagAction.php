<?php

namespace App\Actions\Tag;

use App\Core\Request\Request;
use App\Exceptions\DbException;

/**
 * Class GetPostsByTagAction
 *
 * @package App\Actions\Tag
 */
class GetPostsByTagAction extends AbstractTagAction
{
    /**
     * @const
     */
    const PAGE_LENGTH = 5;

    /**
     * @param Request $request
     * @param string  $slug
     *
     * @return mixed
     */
    public function execute(Request $request, string $slug)
    {
        $params = [
            'page'   => $request->getQueryParams()->page(),
            'length' => $this::PAGE_LENGTH,
            'slug'   => $slug,
        ];

        try {
            return $this->getAll($params);
        } catch (DbException $e) {
            $this->logger->error('Error: ' . $e->getMessage());
            die('Error: ' . $e->getMessage());
        }
    }

    /**
     * @param $params
     *
     * @return array
     */
    private function getAll($params): array
    {
        $posts = $this->tagModel->getPostsByTag($params);
        $pagination = $this->pagination($params['slug']);

        return [
            'posts'       => $posts,
            'pagesArray'  => $pagination,
            'currentPage' => $params['page'],
            'lastPage'    => end($pagination),
        ];
    }

    /**
     * @param string $slug
     *
     * @return array
     */
    private function pagination(string $slug): array
    {
        $numberOfPosts = $this->tagModel->count($slug);
        $numberOfPages = ceil($numberOfPosts / self::PAGE_LENGTH);
        $pagination = [];

        for ($x = 1; $x <= $numberOfPages; $x++) {
            $pagination[$x] = $x;
        }

        return $pagination;
    }
}
