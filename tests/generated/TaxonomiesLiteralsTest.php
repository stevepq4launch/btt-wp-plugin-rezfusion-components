<?php

/**
 * @file Tests for Taxonomies literals.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Taxonomies;

class TaxonomiesLiteralsTest extends BaseTestCase
{
    public function testAmenities()
    {
        $this->assertNotEmpty('rzf_amenities');
        $this->assertIsString('rzf_amenities');
        $this->assertSame('rzf_amenities', Taxonomies::amenities());
    }

    public function testLocation()
    {
        $this->assertNotEmpty('rzf_location');
        $this->assertIsString('rzf_location');
        $this->assertSame('rzf_location', Taxonomies::location());
    }

    public function testType()
    {
        $this->assertNotEmpty('rzf_type');
        $this->assertIsString('rzf_type');
        $this->assertSame('rzf_type', Taxonomies::type());
    }

}
