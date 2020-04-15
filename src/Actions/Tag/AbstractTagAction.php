<?php

namespace App\Actions\Tag;

use App\Core\Loggers\LoggerInterface;
use App\Domain\Tag;
use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Models\Tag\TagModelInterface;

/**
 * Class AbstractTagAction
 *
 * @package App\Actions\Tag
 */
abstract class AbstractTagAction
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var TagModelInterface
     */
    protected $tagModel;

    /**
     * @var Tag
     */
    protected $tag;

    /**
     * AbstractTagAction constructor.
     *
     * @param LoggerInterface   $logger
     * @param TagModelInterface $tagModel
     * @param Tag               $tag
     */
    public function __construct(
        LoggerInterface $logger,
        TagModelInterface $tagModel,
        Tag $tag
    ) {
        $this->logger = $logger;
        $this->tagModel = $tagModel;
        $this->tag = $tag;
    }

    /**
     * @param string $slug
     *
     * @return Tag|bool
     * @throws DbException
     */
    protected function tagExists(string $slug)
    {
        try {
            return $this->tagModel->get($slug);
        } catch (NotFoundException $e) {
            return false;
        } catch (DbException $e) {
            throw $e;
        }
    }
}
