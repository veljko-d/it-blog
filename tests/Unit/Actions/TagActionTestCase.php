<?php

namespace Tests\Unit\Actions;

use App\Core\Loggers\MonologDriver;
use App\Domain\Tag;
use App\Models\Tag\TagModel;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\AbstractTestCase;

/**
 * Class TagActionTestCase
 *
 * @package Tests\Unit\Actions
 */
class TagActionTestCase extends AbstractTestCase
{
    /**
     * @var MonologDriver|MockObject
     */
    protected $logger;

    /**
     * @var TagModel|MockObject
     */
    protected $tagModel;

    /**
     * @var Tag|MockObject
     */
    protected $tag;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        $this->logger = $this->createMock(MonologDriver::class);
        $this->tagModel = $this->createMock(TagModel::class);
        $this->tag = $this->createMock(Tag::class);
    }
}
