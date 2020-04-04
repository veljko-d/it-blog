<?php

namespace App\Actions\Post;

use App\Exceptions\DbException;

/**
 * Class DeletePostAction
 *
 * @package App\Actions\Post
 */
class DeletePostAction extends AbstractPostAction
{
    /**
     * @param string $slug
     *
     * @return array
     */
    public function execute(string $slug)
    {
        try {
            $this->postModel->delete($slug);
        } catch (DbException $e) {
            $this->logger->error('Error deleting post: ' . $e->getMessage());
            return ['message' => 'Error deleting post'];
        }

        return ['status' => 'Post successfully deleted!'];
    }
}
