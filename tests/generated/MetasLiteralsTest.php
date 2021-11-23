<?php

/**
 * @file Tests for Metas names.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Metas;

class MetasLiteralsTest extends BaseTestCase
{
    public function testBedsValueIsValid()
    {
        $this->assertSame('rezfusion_hub_beds', Metas::beds());
    }

    public function testBedsIsNotEmpty()
    {
        $this->assertNotEmpty(Metas::beds());
    }

    public function testBathsValueIsValid()
    {
        $this->assertSame('rezfusion_hub_baths', Metas::baths());
    }

    public function testBathsIsNotEmpty()
    {
        $this->assertNotEmpty(Metas::baths());
    }

    public function testCategoryIdValueIsValid()
    {
        $this->assertSame('rezfusion_hub_category_id', Metas::categoryId());
    }

    public function testCategoryIdIsNotEmpty()
    {
        $this->assertNotEmpty(Metas::categoryId());
    }

    public function testCategoryValueIdValueIsValid()
    {
        $this->assertSame('rezfusion_hub_category_value_id', Metas::categoryValueId());
    }

    public function testCategoryValueIdIsNotEmpty()
    {
        $this->assertNotEmpty(Metas::categoryValueId());
    }

    public function testItemIdValueIsValid()
    {
        $this->assertSame('rezfusion_hub_item_id', Metas::itemId());
    }

    public function testItemIdIsNotEmpty()
    {
        $this->assertNotEmpty(Metas::itemId());
    }

    public function testPromoListingValueValueIsValid()
    {
        $this->assertSame('rzf_promo_listing_value', Metas::promoListingValue());
    }

    public function testPromoListingValueIsNotEmpty()
    {
        $this->assertNotEmpty(Metas::promoListingValue());
    }

    public function testPromoCodeValueValueIsValid()
    {
        $this->assertSame('rzf_promo_code_value', Metas::promoCodeValue());
    }

    public function testPromoCodeValueIsNotEmpty()
    {
        $this->assertNotEmpty(Metas::promoCodeValue());
    }

}
