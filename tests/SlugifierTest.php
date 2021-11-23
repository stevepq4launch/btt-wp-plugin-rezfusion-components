<?php

/**
 * @file Tests for Slugifier.
 */

namespace Rezfusion\Tests;

use Rezfusion\Helper\Slugifier;
use Rezfusion\Helper\SlugifierInterface;

class SlugifierTest extends BaseTestCase
{
    /**
     * @var SlugifierInterface
     */
    private $Slugifier;

    public function setUp(): void
    {
        parent::setUp();
        $this->Slugifier = new Slugifier;
    }

    public function testSlugifier()
    {
        $this->assertInstanceOf(SlugifierInterface::class, $this->Slugifier);
        $this->assertInstanceOf(Slugifier::class, $this->Slugifier);
    }

    public function testSlugify()
    {
        $this->assertSame($this->Slugifier->slugify('/slug/'), 'slug');
        $this->assertSame($this->Slugifier->slugify('TEST/-SL/UG/-///TEST'), 'test-slug-test');
    }
}
