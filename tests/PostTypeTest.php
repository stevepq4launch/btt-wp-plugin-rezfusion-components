<?php

/**
 * @file Test posts types.
 */

namespace Rezfusion\Tests;

use Rezfusion\PostTypes;

class PostTypeTest extends BaseTestCase
{
    public function testListing()
    {
        $this->assertSame(PostTypes::listing(), 'vr_listing');
    }
    public function testPromo()
    {
        $this->assertSame(PostTypes::promo(), 'vr_promo');
    }
}
