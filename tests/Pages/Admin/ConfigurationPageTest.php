<?php

namespace Rezfusion\Tests\Pages\Admin;

use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Pages\Admin\ConfigurationPage;
use Rezfusion\Pages\Page;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class ConfigurationPageTest extends BaseTestCase
{
    public function testPageName(): void
    {
        $this->assertSame('rezfusion_components_config', ConfigurationPage::pageName());
    }

    private function makeConfigurationPage(): ConfigurationPage
    {
        return new ConfigurationPage(new Template(Templates::configurationPageTemplate()));
    }

    public function testGeneralTabName()
    {
        $this->assertSame('general', ConfigurationPage::generalTabName());
    }

    public function testReviewsTabName()
    {
        $this->assertSame('reviews', ConfigurationPage::reviewsTabName());
    }

    public function testPoliciesTabName()
    {
        $this->assertSame('policies', ConfigurationPage::policiesTabName());
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

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testDisplay(): void
    {
        $this->setOutputCallback(function ($html) {
            TestHelper::assertStrings($this, $html, [
                '<label for="rezfusion_hub_promo_code_flag_text">Text on flag for properties with active promo-codes (<i>Default: "Special!"</i>).</label>',
                '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  /></p>    <input type="hidden" name="rezfusion-settings-submit" value=\'Y\'>',
                '<select name="rezfusion_hub_env">',
                '<select name="rezfusion_hub_sync_items_post_type">',
                '<input type="button" value="Refresh Data" id="rezfusion-hub-fetch-data-button" class="button button-primary" />',
                '<input type="text" name="rezfusion_hub_custom_listing_slug" value="" />',
                '<input type="text" name="rezfusion_hub_custom_promo_slug" value="" />',
                '<input type="text" name="rezfusion_hub_promo_code_flag_text" value="" />',
                '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />',
                '<input type="hidden" name="rezfusion-settings-submit" value=\'Y\'>',
                '<input type=\'hidden\' name=\'option_page\' value=\'rezfusion-components\' />',
                '<input type="hidden" name="action" value="update" />',
                '<input type="hidden" name="_wp_http_referer" value="" />'
            ]);
            TestHelper::assertRegExps($this, $html, [
                '/\<h1\>Rezfusion Components\<\/h1\>/i',
                '/\<input type="text" name="rezfusion_hub_folder" value="http/i',
                '/\<input type=\'hidden\' name=\'option_page\' value=\'rezfusion-components\' \/\>/i',
                '/\<input type="hidden" name="action" value="update" \/\>/i',
                '/\<input type="hidden" id="_wpnonce" name="_wpnonce"/i',
                '/\<input type="hidden" name="_wp_http_referer" value="" \/\>/i',
                '/\<input type="hidden" id="_wpnonce" name="_wpnonce" value=".*" \/\>/i',
                '/\<input type="text" name="rezfusion_hub_folder" value="http/i',
                '/\<input type="text" name="rezfusion_hub_repository_token" value=".*" \/\>/i'
            ]);
            $this->assertTrue(true);
        });
        TestHelper::includeTemplateFunctions();
        $this->makeConfigurationPage()->display();
    }

    private function deleteOptions(array $options = []): void
    {
        foreach ($options as $option) {
            OptionManager::delete($option);
        }
    }

    private function doSaveTest(Page $Page, $tabName = '', array $optionsNames = []): void
    {
        $options = [];
        foreach ($optionsNames as $i => $option) {
            $options[$option] = 'a' . ($i + 1);
        }
        $this->setOutputCallback(function ($html) {
        });
        TestHelper::includeTemplateFunctions();
        $_SESSION[ConfigurationPage::saveTabSessionVariableName()] = $tabName;
        if (count($options)) {
            $_POST = array_merge($_POST, $options);
        }
        $Page->display();
        if (count($options)) {
            foreach ($options as $option => $value) {
                $this->assertSame($value, OptionManager::get($option));
            }
        }
        if (count($optionsNames)) {
            $this->deleteOptions($optionsNames);
        }
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testGeneralSave(): void
    {
        $this->doSaveTest($this->makeConfigurationPage(), ConfigurationPage::generalTabName(), [
            Options::redirectUrls(),
            Options::syncItems(),
            Options::syncItemsPostType(),
            Options::customListingSlug(),
            Options::customPromoSlug(),
            Options::promoCodeFlagText()
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testPoliciesSave(): void
    {
        $this->doSaveTest($this->makeConfigurationPage(), ConfigurationPage::policiesTabName(), [
            Options::policiesGeneral(),
            Options::policiesPets(),
            Options::policiesPayment(),
            Options::policiesCancellation(),
            Options::policiesChanging(),
            Options::policiesInsurance(),
            Options::policiesCleaning()
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testAmenitiesSave(): void
    {
        $this->doSaveTest($this->makeConfigurationPage(), ConfigurationPage::amenitiesTabName(), [
            Options::amenitiesFeatured(),
            Options::amenitiesGeneral()
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testFormsSave(): void
    {
        $this->doSaveTest($this->makeConfigurationPage(), ConfigurationPage::formsTabName(), [
            Options::reviewButtonText(),
            Options::reviewForm(),
            Options::inquiryButtonText(),
            Options::inquiryForm()
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testUrgencyAlertSave(): void
    {
        $this->doSaveTest($this->makeConfigurationPage(), ConfigurationPage::urgencyAlertTabName(), [
            Options::urgencyAlertEnabled(),
            Options::urgencyAlertDaysThreshold(),
            Options::urgencyAlertMinimumVisitors(),
            Options::urgencyAlertHighlightedText(),
            Options::urgencyAlertText()
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testFeaturedPropertiesSave(): void
    {
        $this->doSaveTest($this->makeConfigurationPage(), ConfigurationPage::featuredPropertiesTabName(), [
            Options::featuredPropertiesUseIcons(),
            Options::featuredPropertiesBedsLabel(),
            Options::featuredPropertiesBathsLabel(),
            Options::featuredPropertiesSleepsLabel(),
            Options::featuredPropertiesIds()
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testReviewsSave(): void
    {
        $this->doSaveTest($this->makeConfigurationPage(), ConfigurationPage::reviewsTabName(), [
            Options::newReviewNotificationRecipients()
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testDefaultSave(): void
    {
        /* Option will not be updated so we have to cover this. */
        OptionManager::update(Options::promoCodeFlagText(), 'a1');
        $this->doSaveTest($this->makeConfigurationPage(), '', [
            Options::promoCodeFlagText()
        ]);
        $this->assertTrue(true);
    }
}
