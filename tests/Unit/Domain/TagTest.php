<?php

namespace Tests\Unit\Domain;

use Tests\AbstractTestCase;
use App\Domain\Tag;

/**
 * Class TagTest
 *
 * @package Tests\Unit\Domain
 */
class TagTest extends AbstractTestCase
{
    /**
     * @var
     */
    private $tag;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        $this->tag = new Tag;

        $this->tag->create('Tag Name', 'tag-name');
    }

    /**
     * @test
     */
    public function testClassInstance()
    {
        $this->assertInstanceOf(
            Tag::class,
            $this->tag,
            'Created object is not the instance of the Tag class.'
        );
    }

    /**
     * @test
     */
    public function testGetData()
    {
        $this->assertSame(
            'Tag Name',
            $this->tag->getName(),
            'Name is incorrect.'
        );

        $this->assertSame(
            'tag-name',
            $this->tag->getSlug(),
            'Slug is incorrect.'
        );
    }
}
