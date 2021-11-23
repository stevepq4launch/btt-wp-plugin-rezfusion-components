<?php

/**
 * @file Tests for ConfigurationPage literals.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Pages\Admin\ConfigurationPage;

class ConfigurationPageLiteralsTest extends BaseTestCase
{
    public function testGeneralTabName()
    {
        $this->assertSame('general', ConfigurationPage::generalTabName());
    }

    public function testPoliciesTabName()
    {
        $this->assertSame('policies', ConfigurationPage::policiesTabName());
    }

    public function testReviewsTabName()
    {
        $this->assertSame('reviews', ConfigurationPage::reviewsTabName());
    }

    public function testAmenitiesTabName()
    {
        $this->assertSame('amenities', ConfigurationPage::amenitiesTabName());
    }

    public function testFormsTabName()
    {
        $this->assertSame('forms', ConfigurationPage::formsTabName());
    }

    public function testUrgencyAlertTabName()
    {
        $this->assertSame('urgency-alert', ConfigurationPage::urgencyAlertTabName());
    }

    public function testFeaturedPropertiesTabName()
    {
        $this->assertSame('featured-properties', ConfigurationPage::featuredPropertiesTabName());
    }

    public function testSaveTabSessionVariableName()
    {
        $this->assertSame('savetab', ConfigurationPage::saveTabSessionVariableName());
    }

    public function testPageName()
    {
        $this->assertSame('rezfusion_components_config', ConfigurationPage::pageName());
    }

    public function testTabGetParameterName()
    {
        $this->assertSame('tab', ConfigurationPage::tabGetParameterName());
    }

}
