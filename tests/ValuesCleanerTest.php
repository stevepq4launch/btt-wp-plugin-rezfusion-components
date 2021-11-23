<?php

/**
 * @file Tests for ValuesCleaner.
 */

namespace Rezfusion\Tests;

use Rezfusion\Factory\ValuesCleanerFactory;
use Rezfusion\Options;
use Rezfusion\ValuesCleaner;

class ValuesCleanerTest extends BaseTestCase
{
    /**
     * @var ValuesCleaner
     */
    private $ValuesCleaner;

    public function setUp(): void
    {
        parent::setUp();
        $this->ValuesCleaner = (new ValuesCleanerFactory())->make();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(ValuesCleaner::class, $this->ValuesCleaner);
    }

    public function testTrimSlases()
    {
        $values = [
            Options::customListingSlug() => 'Custom/-/lIsTI/NG/-sluG',
            Options::customPromoSlug() => '////cUsToM-//Pr/OMO///-/slug//',
            Options::componentsURL() => 'http://components-url///'
        ];
        $values = $this->ValuesCleaner->clean($values);
        $this->assertIsArray($values);
        $this->assertSame('custom-listing-slug', $values[Options::customListingSlug()]);
        $this->assertSame('custom-promo-slug', $values[Options::customPromoSlug()]);
        $this->assertSame('http://components-url', $values[Options::componentsURL()]);
    }
}
