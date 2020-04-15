<?php

namespace App\Actions\Tag;

use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Utils\Slug\SlugGenerator;

/**
 * Class StoreTagsAction
 *
 * @package App\Actions\Tag
 */
class StoreTagsAction extends AbstractTagAction
{
    /**
     * @param string $tags
     * @param int    $postId
     *
     * @throws DbException
     * @throws NotFoundException
     */
    public function execute(string $tags, int $postId)
    {
        $tags = explode('|', $tags);
        $tags = array_filter(array_map('trim', $tags));

        if ($existingTags = $this->tagModel->getByPost($postId)) {
            $this->detachIfNotPresent($existingTags, $tags, $postId);
        }

        if (empty($tags)) {
            return;
        }

        foreach ($tags as $tagName) {
            $this->storeTag($tagName, $postId);
        }
    }

    /**
     * @param array $existingTags
     * @param array $tags
     * @param int   $postId
     */
    private function detachIfNotPresent(array $existingTags, array $tags, int $postId)
    {
        $existingTagsArray = [];

        foreach ($existingTags as $existingTag) {
            $existingTagsArray[$existingTag->getId()] = $existingTag->getName();
        }

        if (!empty($toDelete = array_diff($existingTagsArray, $tags))) {
            foreach ($toDelete as $tagId => $tagName) {
                $this->tagModel->detachTagAndPost($postId, $tagId);
            }
        }
    }

    /**
     * @param string $tagName
     * @param int    $postId
     *
     * @throws DbException
     * @throws NotFoundException
     */
    private function storeTag(string $tagName, int $postId)
    {
        try {
            $this->store($tagName, $postId);
        } catch (DbException | NotFoundException $e) {
            throw $e;
        }
    }

    /**
     * @param string $tagName
     * @param int    $postId
     *
     * @throws DbException
     */
    private function store(string $tagName, int $postId)
    {
        $slug = SlugGenerator::slugify($tagName);

        if ($tag = $this->tagExists($slug)) {
            $this->tagModel->attachTagToPost($postId, $tag->getId());
        } else {
            $tag = $this->tag->create($tagName, $slug);
            $tag = $this->tagModel->store($tag);
            $this->tagModel->attachTagToPost($postId, $tag->getId());
        }
    }
}
