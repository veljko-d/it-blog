<?php

namespace Tests\Unit\Utils;

use Tests\AbstractTestCase;
use App\Utils\Slug\SlugGenerator;

/**
 * Class SlugGeneratorTest
 *
 * @package Tests\Unit\Utils
 */
class SlugGeneratorTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testSlugify()
    {
        $text = 'As of September 2019, over 60% of sites on the web using PHP'
            . ' are still on discontinued/"EOLed" version 5.6 or older; versions'
            . ' prior to 7.2 are no longer officially supported by The PHP'
            . ' Development Team, but security support is provided by third'
            . ' parties, such as Debian.';

        $expected = 'as-of-september-2019-over-60-of-sites-on-the-web-using-'
            . 'php-are-still-on-discontinued-eoled-version-5-6-or-older-'
            . 'versions-prior-to-7-2-are-no-longer-officially-supported-by-'
            . 'the-php-development-team-but-security-support-is-provided-by-'
            . 'third-parties-such-as-debian';

        $this->assertSame(
            $expected,
            SlugGenerator::slugify($text),
            "Slugs don't match."
        );
    }
}
