<?php

use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\TestBuilder\TestBuilder;

require_once(__DIR__ . '/../../../wp-config.php');

echo "\n";
echo "Will try to build all required tests.\n\n";

$TestBuilder = new TestBuilder();

/**
 * Creates data for OptionsHandlerTest.
 * 
 * @return array
 */
function makeOptionsHandlerTestData(): array
{
    $OptionsHandler = OptionsHandlerProvider::getInstance();
    $optionsHandlerData = [];
    foreach ($OptionsHandler->getPluginConfigurationMap() as $option => $method) {
        $optionsHandlerData[] = ['PluginConfiguration', $option, $method];
    }
    foreach ($OptionsHandler->getHubConfigurationMap() as $option => $method) {
        $optionsHandlerData[] = ['HubConfiguration', $option, $method];
    }
    return $optionsHandlerData;
}

/**
 * @param TestBuilder $TestBuilder
 * @param string $file
 * @param array $use
 * @param string $className
 * @param string $description
 * @param array $callbackData
 * @param callable $callbackFunction
 * @param array $classPreContent
 * 
 * @return void
 */
function runBuilder(TestBuilder $TestBuilder, $file = '', $use = [], $className = '', $description = '', $callbackData = [], callable $callbackFunction, $classPreContent = []): void
{
    $TestBuilder
        ->reset()
        ->withUse(['Rezfusion\Tests\BaseTestCase'])
        ->withNamespace('Rezfusion\Tests\Generated')
        ->withExtends('BaseTestCase')
        ->withUse($use)
        ->withOutputToFile(__DIR__ . "/tests/generated/" . $file)
        ->withDescription($description)
        ->withClassName($className)
        ->withCustomCallback($callbackData, $callbackFunction);

    if (count($classPreContent)) {
        foreach ($classPreContent as $classPreContent_) {
            $TestBuilder->withClassPreContent($classPreContent_);
        }
    }

    $TestBuilder->build();
}

runBuilder($TestBuilder, 'FiltersLiteralsTest.php', ['Rezfusion\Filters'], 'FiltersLiteralsTest', 'Tests for filters names.', [
    [Filters::class, 'reviewsAllowedUserRoles', [], 'rezfusion_reviews_allowed_user_roles'],
    [Filters::class, 'managePostTypePostsColumns', ['test-post-type'], 'manage_test-post-type_posts_columns'],
    [Filters::class, 'pluginName', [], 'rezfusion_plugin_name'],
    [Filters::class, 'variables', ["test-variable"], 'variables_test-variable']
], function ($class, $method, $arguments, $expected) use ($TestBuilder) {
    return "    public function test" . ucfirst($method) . "IsValid()\n    {\n        \$this->assertSame($class::$method(" . $TestBuilder->renderArgumentsString($arguments) . "), '$expected');\n    }\n\n";
});

runBuilder($TestBuilder, 'MetasLiteralsTest.php', ['Rezfusion\Metas'], 'MetasLiteralsTest', 'Tests for Metas names.', [
    [Metas::class, 'beds', 'rezfusion_hub_beds'],
    [Metas::class, 'baths', 'rezfusion_hub_baths'],
    [Metas::class, 'categoryId', 'rezfusion_hub_category_id'],
    [Metas::class, 'categoryValueId', 'rezfusion_hub_category_value_id'],
    [Metas::class, 'itemId', 'rezfusion_hub_item_id'],
    [Metas::class, 'promoListingValue', 'rzf_promo_listing_value'],
    [Metas::class, 'promoCodeValue', 'rzf_promo_code_value']
],  function ($class, $method, $expected) {
    return "    public function test" . ucfirst($method) . "ValueIsValid()\n    {\n        \$this->assertSame('$expected', $class::$method());\n    }\n\n"
        . "    public function test" . ucfirst($method) . "IsNotEmpty()\n    {\n        \$this->assertNotEmpty($class::$method());\n    }\n\n";
});

runBuilder($TestBuilder, 'TemplatesLiteralsTest.php', ['Rezfusion\Templates'], 'TemplatesLiteralsTest', 'Tests for Templates names.', [
    [Templates::class, 'featuredPropertiesTemplate', 'vr-featured-properties.php'],
    [Templates::class, 'featuredPropertiesConfigurationTemplate', 'admin/configuration-featured-properties.php'],
    [Templates::class, 'reviewsTemplate', 'vr-reviews.php'],
    [Templates::class, 'reviewSubmitFormTemplate', 'vr-review-submit-form.php'],
    [Templates::class, 'reviewsConfigurationPage', 'admin/configuration-reviews.php'],
    [Templates::class, 'reviewsListPage', 'admin/reviews-list.php'],
    [Templates::class, 'modalOpenPartial', 'partials/vr-modal-open.php'],
    [Templates::class, 'modalClosePartial', 'partials/vr-modal-close.php'],
    [Templates::class, 'propertyDetailsParial', 'partials/property-details.php'],
    [Templates::class, 'hubConfigurationTemplate', 'admin/hub-configuration.php'],
    [Templates::class, 'quickSearchTemplate', 'vr-quick-search.php'],
    [Templates::class, 'mapTemplate', 'vr-url-map.php'],
    [Templates::class, 'componentTemplate', 'vr-component.php'],
    [Templates::class, 'detailsPageTemplate', 'vr-details-page.php'],
    [Templates::class, 'itemFlagTemplate', 'vr-item-flag.php'],
    [Templates::class, 'itemPhotosTemplate', 'vr-item-photos.php'],
    [Templates::class, 'itemAvailPickerTemplate', 'vr-item-avail-picker.php'],
    [Templates::class, 'itemAvailCalendarTemplate', 'vr-item-avail-calendar.php'],
    [Templates::class, 'itemPoliciesTemplate', 'vr-item-policies.php'],
    [Templates::class, 'itemReviewsTemplate', 'vr-item-reviews.php'],
    [Templates::class, 'itemAmenitiesTemplate', 'vr-item-amenities.php'],
    [Templates::class, 'favoriteToggleTemplate', 'vr-favorite-toggle.php'],
    [Templates::class, 'favoritesTemplate', 'vr-favorites.php'],
    [Templates::class, 'searchTemplate', 'vr-search.php'],
    [Templates::class, 'urgencyAlertTemplate', 'vr-urgency-alert.php'],
    [Templates::class, 'propertiesAdTemplate', 'vr-properties-ad.php'],
    [Templates::class, 'generalConfigurationTemplate', 'admin/configuration-general.php'],
    [Templates::class, 'policiesConfigurationTemplate', 'admin/configuration-policies.php'],
    [Templates::class, 'amenitiesConfigurationTemplate', 'admin/configuration-amenities.php'],
    [Templates::class, 'formsConfigurationTemplate', 'admin/configuration-forms.php'],
    [Templates::class, 'urgencyAlertConfigurationTemplate', 'admin/configuration-urgency-alert.php'],
    [Templates::class, 'configurationPageTemplate', 'admin/configuration.php'],
    [Templates::class, 'itemsConfigurationPageTemplate', 'admin/lodging-item.php'],
    [Templates::class, 'categoriesConfigurationPageTemplate', 'admin/category-info.php'],
    [Templates::class, 'categoriesDisplayTemplate', 'vr-categories-display.php'],
    [Templates::class, 'sleepingArrangementsTemplate', 'property-sleeping-arrangements.php']
], function ($class, $method, $expected) {
    return "    public function test" . ucfirst($method) . "IsValid()\n    {\n        \$this->assertSame('$expected', $class::$method());\n    }\n\n";
});

runBuilder($TestBuilder, 'HubConfigurationValuesNotEmptyTest.php', [
    'Rezfusion\Configuration\HubConfiguration',
    'Rezfusion\Configuration\HubConfigurationProvider'
], 'HubConfigurationValuesNotEmptyTest', 'Test if HubConfiguration values are not empty.', [
    ['productionEnvironment', true],
    ['developmentEnvironment', true],
    ['defaultProductionBlueprintURL', true],
    ['defaultDevelopmentBlueprintURL', true],
    ['defaultSPS_Domain', true],
    ['themeURL_Key', true],
    ['fontsURL_Key', true],
    ['componentsBundleURL_Key', true],
    ['componentsCSS_URL_Key', true],
    ['getConfigurationURL', false],
    ['getConfiguration', false],
    ['getComponentsURL', false],
    ['getChannelURL', false],
    ['getSPS_Domain', false],
    ['getBookingConfirmationURL', false],
    ['getFavoritesEnabled', false],
    ['getMapAPI_Key', false],
    ['getItemsDetailsPath', false],
    ['getThemeURL', false],
    ['getEnvironment', false],
    ['getBlueprintURL', false],
    ['getFontsURL', false],
    ['getMaxReviewRating', false],
    ['getComponentsBundleURL', false],
    ['getComponentsCSS_URL', false],
    ['getHubConfigurationArray', false]
], function ($method, $static) {
    $methodString = "\$this->HubConfiguration" . ($static === true ? '::' : '->') . "$method()";
    return "    public function test" . ucfirst($method) . "ValueNotEmpty()\n    {\n        \$this->assertNotEmpty($methodString);\n    }\n\n";
}, [
    "    /**\n     * @var HubConfiguration\n     */\n    private \$HubConfiguration;\n",
    "    public function setUp(): void\n    {\n        parent::setUp();\n        \$this->HubConfiguration = HubConfigurationProvider::getInstance();\n    }\n"
]);

runBuilder($TestBuilder, 'PagesNamesTest.php', [], 'PagesNamesTest', 'Tests for pages names.', [
    ['ConfigurationPage', 'rezfusion_components_config'],
    ['CategoryInfoPage', 'rezfusion_components_category_info'],
    ['HubConfigurationPage', 'rezfusion_components_hub_configuration'],
    ['ItemInfoPage', 'rezfusion_components_item_info'],
    ['ReviewsListPage', 'rezfusion_components_reviews_list']
], function ($class, $expected) {
    return "    public function test" . ucfirst($class) . "IsValid()\n    {\n        \$this->assertSame('$expected', \Rezfusion\Pages\Admin\\$class::pageName());\n    }\n\n";
});

runBuilder($TestBuilder, 'OptionsLiteralsTest.php', ['Rezfusion\Options'], 'OptionsLiteralsTest', 'Tests for options names.', [
    ['featuredPropertiesUseIcons', 'rezfusion_hub_featured-properties_use_icons'],
    ['featuredPropertiesBedsLabel', 'rezfusion_hub_featured-properties_beds_label'],
    ['featuredPropertiesBathsLabel', 'rezfusion_hub_featured-properties_baths_label'],
    ['featuredPropertiesSleepsLabel', 'rezfusion_hub_featured-properties_sleeps_label'],
    ['featuredPropertiesIds', 'rezfusion_hub_featured-properties_properties_ids'],
    ['hubChannelURL', 'rezfusion_hub_channel'],
    ['componentsURL', 'rezfusion_hub_folder'],
    ['SPS_Domain', 'rezfusion_hub_sps_domain'],
    ['bookingConfirmationURL', 'rezfusion_hub_conf_page'],
    ['newReviewNotificationRecipients', 'rezfusion_hub_new_review_notification_recipients'],
    ['maxReviewRating', 'rezfusion_hub_max_review_rating'],
    ['repositoryURL', 'rezfusion_hub_repository_url'],
    ['repositoryToken', 'rezfusion_hub_repository_token'],
    ['enableFavorites', 'rezfusion_hub_enable_favorites'],
    ['mapAPI_Key', 'rezfusion_hub_google_maps_api_key'],
    ['customListingSlug', 'rezfusion_hub_custom_listing_slug'],
    ['customPromoSlug', 'rezfusion_hub_custom_promo_slug'],
    ['promoCodeFlagText', 'rezfusion_hub_promo_code_flag_text'],
    ['themeURL', 'rezfusion_hub_theme'],
    ['blueprintURL', 'rezfusion_hub_blueprint_url'],
    ['environment', 'rezfusion_hub_env'],
    ['fontsURL', 'rezfusion_hub_fonts_url'],
    ['configuration', 'rezfusion_hub_configuration'],
    ['redirectUrls', 'rezfusion_hub_redirect_urls'],
    ['triggerRewriteFlush', 'rezfusion_trigger_rewrite_flush'],
    ['syncItems', 'rezfusion_hub_sync_items'],
    ['syncItemsPostType', 'rezfusion_hub_sync_items_post_type'],
    ['policiesGeneral', 'rezfusion_hub_policies_general'],
    ['policiesPets', 'rezfusion_hub_policies_pets'],
    ['policiesPayment', 'rezfusion_hub_policies_payment'],
    ['policiesCancellation', 'rezfusion_hub_policies_cancellation'],
    ['policiesChanging', 'rezfusion_hub_policies_changing'],
    ['policiesInsurance', 'rezfusion_hub_policies_insurance'],
    ['policiesCleaning', 'rezfusion_hub_policies_cleaning'],
    ['amenitiesFeatured', 'rezfusion_hub_amenities_featured'],
    ['amenitiesGeneral', 'rezfusion_hub_amenities_general'],
    ['reviewButtonText', 'rezfusion_hub_review_btn_text'],
    ['reviewForm', 'rezfusion_hub_review_form'],
    ['inquiryButtonText', 'rezfusion_hub_inquiry_btn_text'],
    ['inquiryForm', 'rezfusion_hub_inquiry_form'],
    ['urgencyAlertEnabled', 'rezfusion_hub_urgency_alert_enabled'],
    ['urgencyAlertDaysThreshold', 'rezfusion_hub_urgency_alert_days_threshold'],
    ['urgencyAlertMinimumVisitors', 'rezfusion_hub_urgency_alert_minimum_visitors'],
    ['urgencyAlertHighlightedText', 'rezfusion_hub_urgency_alert_highlighted_text'],
    ['urgencyAlertText', 'rezfusion_hub_urgency_alert_text'],
    ['dateFormat', 'date_format'],
    ['favoritesNamespace', 'rezfusion_hub_favorites_namespace'],
    ['optionGroup', 'rezfusion-components'],
    ['URL_Map', 'rezfusion_hub_url_map'],
    ['componentsBundleURL', 'components_bundle_url'],
    ['componentsCSS_URL', 'components_css_url']
], function ($method, $expected) use ($TestBuilder) {
    return $TestBuilder->renderTestMethod(ucfirst($method), "\$this->assertSame('$expected', Options::$method());");
});

runBuilder($TestBuilder, 'OptionsHandlerValuesTest.php', [
    'Rezfusion\Configuration\HubConfiguration',
    'Rezfusion\Configuration\HubConfigurationProvider',
    'Rezfusion\OptionsHandler',
    'Rezfusion\PluginConfiguration'
], 'OptionsHandlerValuesTest', 'Tests for OptionsHandler values.', makeOptionsHandlerTestData(), function ($class, $option, $method) use ($TestBuilder) {
    return $TestBuilder->renderTestMethod($class . ucfirst($method) . "Value", "\$this->assertSame(\$this->${class}->${method}(), \$this->OptionsHandler->getOption('${option}'));");
}, [
    "    /**\n     * @var HubConfiguration\n     */\n    private \$HubConfiguration;\n\n    /**\n     * @var PluginConfiguration\n     */\n    private \$PluginConfiguration;\n\n"
        . "    /**\n     * @var OptionsHandler\n     */\n    private \$OptionsHandler;\n\n"
        . "    public function setUp(): void\n    {\n        parent::setUp();\n        \$this->HubConfiguration = HubConfigurationProvider::getInstance();\n        \$this->PluginConfiguration = PluginConfiguration::getInstance();\n        \$this->OptionsHandler = new OptionsHandler(\$this->HubConfiguration,\$this->PluginConfiguration);\n    }\n"
]);

runBuilder($TestBuilder, 'ActionsLiteralsTest.php', [
    'Rezfusion\Actions'
], 'ActionsLiteralsTest', 'Tests for Actions literals.', [
    ['init', [], 'init'],
    ['adminEnqueueScripts', [], 'admin_enqueue_scripts'],
    ['wpHead', [], 'wp_head'],
    ['adminInit', [], 'admin_init'],
    ['templateRedirect', [], 'template_redirect'],
    ['adminNotices', [], 'admin_notices'],
    ['restAPI_Init', [], 'rest_api_init'],
    ['wpFooter', [], 'wp_footer'],
    ['adminMenu', [], 'admin_menu'],
    ['addMetaBoxes', [], 'add_meta_boxes'],
    ['savePost', [], 'save_post'],
    ['taxonomyAddFormFields', ['taxonomy-test'], 'taxonomy-test_add_form_fields'],
    ['createdTaxonomy', ['taxonomy-test'], 'created_taxonomy-test'],
    ['taxonomyEditFormFields', ['taxonomy-test'], 'taxonomy-test_edit_form_fields'],
    ['editedTaxonomy', ['taxonomy-test'], 'edited_taxonomy-test'],
    ['managePostTypePostsCustomColumn', ['test-post-type'], 'manage_test-post-type_posts_custom_column'],
    ['enqueueScripts', [], 'wp_enqueue_scripts']
], function ($method, $arguments, $expected) use ($TestBuilder) {
    return $TestBuilder->renderTestMethod(ucfirst($method), "\$this->assertSame('${expected}', Actions::${method}(" . $TestBuilder->renderArgumentsString($arguments) . "));");
});

runBuilder($TestBuilder, 'AssetsLiteralsTest.php', [
    'Rezfusion\Assets'
], 'AssetsLiteralsTest', 'Tests for Assets literals.', [
    ['rezfusionScript', 'rezfusion.js'],
    ['rezfusionStarsRatingStyle', 'rezfusion-stars-rating.css'],
    ['rezfusionStarsRatingScript', 'rezfusion-stars-rating.js'],
    ['rezfusionFieldsValidationStyle', 'rezfusion-fields-validation.css'],
    ['rezfusionFieldsValidationScript', 'rezfusion-fields-validation.js'],
    ['rezfusionModalStyle', 'rezfusion-modal.css'],
    ['rezfusionModalScript', 'rezfusion-modal.js'],
    ['rezfusionReviewSubmitFormScript', 'rezfusion-review-submit-form.js'],
    ['featuredPropertiesConfigurationComponentHandlerScript', 'featured-properties-configuration-component-handler.js'],
    ['featuredPropertiesStyle', 'featured-properties-configuration.css'],
    ['quickSearchStyle', 'vr-quick-search.css'],
    ['propertyCardFlagStyle', 'property-card-flag.css'],
    ['propertyCardFlagScript', 'property-card-flag.js'],
    ['reviewsModalHandlerScript', 'rezfusion-reviews-modal-handler.js'],
    ['favoritesStyle', 'favorites.css'],
    ['localBundleScript', 'rezfusion-components/dist/main.js']

], function ($method, $expected) use ($TestBuilder) {
    return $TestBuilder->renderTestMethod(ucfirst($method), "\$this->assertSame('${expected}', Assets::${method}());");
});

runBuilder($TestBuilder, 'RegisterersTest.php', [
    'Rezfusion\Configuration\HubConfigurationProvider',
    'Rezfusion\Factory\RegisterersContainerFactory',
    'Rezfusion\Helper\AssetsRegisterer',
    'Rezfusion\OptionsHandler',
    'Rezfusion\PluginConfiguration',
    'Rezfusion\Registerer\RegistererInterface'
], 'RegisterersTest', 'Tests for registerers.', [
    ['FunctionsRegisterer'],
    ['PostTypesRegisterer'],
    ['ShortcodesRegisterer'],
    ['RewriteTagsRegisterer'],
    ['DelayedRewriteFlushRegisterer'],
    ['PagesRegisterer'],
    ['SettingsRegisterer'],
    ['TemplateRedirectRegisterer'],
    ['FontsRegisterer'],
    ['SessionRegisterer'],
    ['FeaturedPropertiesConfigurationScriptsRegisterer'],
    ['ControllersRegisterer'],
    ['RezfusionHTML_ComponentsRegisterer'],
    ['ComponentsBundleRegisterer'],
    ['PluginUpdateRegisterer']
], function ($registerer) use ($TestBuilder) {
    $fullClass = "\Rezfusion\Registerer\\${registerer}";
    $content = '';
    $findRegistererString = "\$Registerer = \$this->RegisterersContainer->find(${fullClass}::class);";
    $content .= $TestBuilder->renderTestMethod(ucfirst($registerer) . 'Exists', "{$findRegistererString}\n        \$this->assertNotEmpty(\$Registerer);");
    $content .= $TestBuilder->renderTestMethod(ucfirst($registerer) . 'Instance', "{$findRegistererString}\n        \$this->assertInstanceOf(${fullClass}::class, \$Registerer);");
    $content .= $TestBuilder->renderTestMethod(ucfirst($registerer) . 'Interface', "{$findRegistererString}\n        \$this->assertInstanceOf(RegistererInterface::class, \$Registerer);");
    return $content;
}, [
    "    /**\n     * @var RegisterersContainer\n     */\n    private \$RegisterersContainer;\n\n    public function setUp(): void\n    {\n        parent::setUp();\n        \$this->RegisterersContainer = (new RegisterersContainerFactory(\n            new AssetsRegisterer,\n            new OptionsHandler(HubConfigurationProvider::getInstance(), PluginConfiguration::getInstance())\n        ))->make();\n    }\n"
]);

runBuilder($TestBuilder, 'ConfigurationPageLiteralsTest.php', [
    'Rezfusion\Pages\Admin\ConfigurationPage'
], 'ConfigurationPageLiteralsTest', 'Tests for ConfigurationPage literals.', [
    ['generalTabName', 'general'],
    ['policiesTabName', 'policies'],
    ['reviewsTabName', 'reviews'],
    ['amenitiesTabName', 'amenities'],
    ['formsTabName', 'forms'],
    ['urgencyAlertTabName', 'urgency-alert'],
    ['featuredPropertiesTabName', 'featured-properties'],
    ['saveTabSessionVariableName', 'savetab'],
    ['pageName', 'rezfusion_components_config'],
    ['tabGetParameterName', 'tab']
], function ($method, $expected) use ($TestBuilder) {
    return $TestBuilder->renderTestMethod(ucfirst($method), "\$this->assertSame('${expected}', ConfigurationPage::${method}());");
});

echo "Done.\n\n";
