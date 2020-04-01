<?php

namespace App\Utils\Slug;

use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Models\ModelInterface;

/**
 * Class Slug
 *
 * @package App\Utils\Slug
 */
class Slug
{
    /**
     * @var ModelInterface
     */
    private $model;

    /**
     * @param ModelInterface $model
     */
    public function setModel(ModelInterface $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $title
     *
     * @return string
     */
    public function getSlug(string $title): string
    {
        $slug = SlugGenerator::slugify($title);

        if ($this->entryExists($slug)) {
            $slug .= '-1';

            if ($this->entryExists($slug)) {
                return $this->getSlugWithCounter($slug);
            }

            return $slug;
        }

        return $slug;
    }

    /**
     * @param string $slug
     *
     * @return string
     */
    private function getSlugWithCounter(string $slug): string
    {
        $n = substr($slug, -1);
        $slug = substr($slug, 0, -1) . ++$n;

        if ($this->entryExists($slug)) {
            return $this->getSlugWithCounter($slug);
        }

        return $slug;
    }

    /**
     * @param string $slug
     *
     * @return bool
     */
    private function entryExists(string $slug): bool
    {
        try {
            $this->model->get($slug);
            return true;
        } catch (NotFoundException $e) {
            return false;
        } catch (DbException $e) {
            die('Something went wrong: ' . $e->getMessage());
        }
    }
}
