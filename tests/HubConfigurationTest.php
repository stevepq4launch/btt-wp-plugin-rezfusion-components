<?php

/**
 * @file Tests for HubConfiguration.
 */

namespace Rezfusion\Tests;

use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\ConfigurationProcessor;
use Rezfusion\Factory\CustomHubConfigurationFactory;
use Rezfusion\Metas;
use Rezfusion\Plugin;
use Rezfusion\PostTypes;
use Rezfusion\Provider\CustomHubConfigurationProvider;
use Rezfusion\Taxonomies;

class HubConfigurationTest extends BaseTestCase
{
    /**
     * @var HubConfiguration
     */
    private $HubConfiguration;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        Plugin::refreshData();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->HubConfiguration = HubConfigurationProvider::getInstance();
    }

    private function createPromoPost()
    {
        global $wpdb;
        $unitPostId = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type = %s LIMIT 1", [PostTypes::listing()]));
        return wp_insert_post([
            'post_type' => PostTypes::promo(),
            'post_status' => 'publish',
            'post_title' => 'PromoTest',
            'meta_input' => [
                Metas::promoCodeValue() => "TEST",
                Metas::promoListingValue() => [
                    $unitPostId
                ]
            ]
        ]);
    }

    public function testProviderGetInstance()
    {
        $this->assertInstanceOf(HubConfiguration::class, $this->HubConfiguration);
    }

    public function testProductionEnvironmentName()
    {
        $this->assertSame($this->HubConfiguration::productionEnvironment(), 'prd');
    }

    public function testDevelopmentEnvironmentName()
    {
        $this->assertSame($this->HubConfiguration::developmentEnvironment(), 'dev');
    }

    public function testDefaultProductionBlueprintURL()
    {
        $this->assertSame($this->HubConfiguration::defaultProductionBlueprintURL(), 'https://blueprint.rezfusion.com/graphql');
    }

    public function testDefaultDevelopmentBlueprintURL()
    {
        $this->assertSame($this->HubConfiguration::defaultDevelopmentBlueprintURL(), 'https://blueprint.hub-stg.rezfusion.com/graphql');
    }

    public function testDefaultSPS_Domain()
    {
        $this->assertSame($this->HubConfiguration::defaultSPS_Domain(), 'https://checkout.rezfusion.com');
    }

    public function testThemeURL_Key()
    {
        $this->assertSame($this->HubConfiguration::themeURL_Key(), 'themeURL');
    }

    public function testFontsURL_Key()
    {
        $this->assertSame($this->HubConfiguration::fontsURL_Key(), 'fontsURL');
    }

    public function testMaxReviewsRatingIsInteger()
    {
        $this->assertIsInt($this->HubConfiguration->getMaxReviewRating());
    }

    public function testMaxReviewsRatingIsGreaterThanZero()
    {
        $this->assertGreaterThan(0, $this->HubConfiguration->getMaxReviewRating());
    }

    public function testSeparateConfigurationObjects()
    {
        $HubConfiguration = $this->HubConfiguration;
        $this->assertInstanceOf(HubConfiguration::class, $HubConfiguration);
        $CustomHubConfiguration = CustomHubConfigurationProvider::getInstance();
        $this->assertInstanceOf(HubConfiguration::class, $CustomHubConfiguration);
        $optionPath = 'hub_configuration.settings.components.AvailabilitySearchConsumer.options.minAdvance';
        $this->assertSame(1, $HubConfiguration->getValue($optionPath));
        $this->assertSame(1, $CustomHubConfiguration->getValue($optionPath));
        $CustomHubConfiguration->setValue($optionPath, 5);
        $this->assertSame(1, $HubConfiguration->getValue($optionPath));
        $this->assertSame(5, $CustomHubConfiguration->getValue($optionPath));
    }

    public function testPromoItemsIdsFilter()
    {
        $CustomHubConfigurationFactory = new CustomHubConfigurationFactory();
        $ConfigurationProcessor = new ConfigurationProcessor();
        $itemsIdsOptionName = 'hub_configuration.settings.components.SearchProvider.filters.itemIds';
        $CustomConfiguration = $CustomHubConfigurationFactory->make();

        $itemsIds = $CustomConfiguration->getValue($itemsIdsOptionName);
        $this->assertEmpty($itemsIds);
        $this->assertNull($itemsIds);
        global $post;
        $postID = $this->createPromoPost();
        $this->assertNotEmpty($postID);
        $post = get_post($postID);
        $this->assertIsObject($post);
        $ConfigurationProcessor->process($CustomConfiguration);
        $itemsIds = $CustomConfiguration->getValue($itemsIdsOptionName);
        $this->assertNotEmpty($itemsIds);
        $this->assertIsArray($itemsIds);
        $this->assertCount(1, $itemsIds);
    }

    public function testCategoriesFilter()
    {
        $CustomHubConfigurationFactory = new CustomHubConfigurationFactory();
        $ConfigurationProcessor = new ConfigurationProcessor();
        $categoriesOptionName = 'hub_configuration.settings.components.SearchProvider.filters.categoryFilter.categories';
        $CustomConfiguration = $CustomHubConfigurationFactory->make();

        $categories = $CustomConfiguration->getValue($categoriesOptionName);
        $this->assertEmpty($categories);
        $this->assertNull($categories);

        $terms = get_terms(['taxonomy' => Taxonomies::amenities(), 'hide_empty' => 0]);
        $termId = @$terms[0]->term_id;
        $this->assertNotEmpty($termId);
        $this->assertIsNumeric($termId);
        global $wp_query;
        $wp_query = new \WP_Query([
            'post_type' => PostTypes::listing(),
            'tax_query' => [[
                'taxonomy' => Taxonomies::amenities(),
                'field' => 'id',
                'terms' => $termId
            ]]
        ]);

        $categoryIdKey = 'cat_id';
        $categoryValuesKey = 'values';
        $categoryOperatorKey = 'operator';

        $ConfigurationProcessor->process($CustomConfiguration);
        $categories = $CustomConfiguration->getValue($categoriesOptionName);

        $this->assertNotEmpty($categories);
        $this->assertIsArray($categories);
        $this->assertCount(3, $categories);

        $this->assertArrayHasKey($categoryIdKey, $categories);
        $this->assertArrayHasKey($categoryValuesKey, $categories);
        $this->assertArrayHasKey($categoryOperatorKey, $categories);

        $this->assertIsInt($categories[$categoryIdKey]);
        $this->assertSame(214, $categories[$categoryIdKey]);

        $this->assertIsArray($categories[$categoryValuesKey]);
        $this->assertCount(1, $categories[$categoryValuesKey]);
        $this->assertSame([3654], $categories[$categoryValuesKey]);
        $this->assertSame(3654, $categories[$categoryValuesKey][0]);

        $this->assertIsString($categories[$categoryOperatorKey]);
        $this->assertSame('AND', $categories[$categoryOperatorKey]);

        wp_reset_query();
    }
}
