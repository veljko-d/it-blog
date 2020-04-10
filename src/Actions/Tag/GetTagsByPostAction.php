<?php

namespace App\Actions\Tag;

/**
 * Class GetTagsByPostAction
 *
 * @package App\Actions\Tag
 */
class GetTagsByPostAction extends AbstractTagAction
{
    /**
     * @param int $postId
     *
     * @return array
     */
    public function execute(int $postId): array
    {
        return $this->tagModel->getByPost($postId);
    }
}
