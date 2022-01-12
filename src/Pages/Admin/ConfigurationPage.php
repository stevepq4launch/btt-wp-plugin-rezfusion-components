<?php

/**
 * @file - Render a page for entering rezfusion
 * configuration options.
 */

namespace Rezfusion\Pages\Admin;

use Rezfusion\Actions;
use Rezfusion\Options;
use Rezfusion\Factory\ValuesCleanerFactory;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Pages\Page;
use Rezfusion\Plugin;

Plugin::getInstance()->initializeSession();

class ConfigurationPage extends Page
{

  /**
   * @var string
   */
  const PAGE_NAME = 'rezfusion_components_config';

  /**
   * @var string
   */
  const GENERAL_TAB_NAME = 'general';

  /**
   * @var string
   */
  const REVIEWS_TAB_NAME = 'reviews';

  /**
   * @var string
   */
  const POLICIES_TAB_NAME = 'policies';

  /**
   * @var string
   */
  const AMENITIES_TAB_NAME = 'amenities';

  /**
   * @var string
   */
  const FORMS_TAB_NAME = 'forms';

  /**
   * @var string
   */
  const URGENCY_ALERT_TAB_NAME = 'urgency-alert';

  /**
   * @var string
   */
  const FEATURED_PROPERTIES_TAB_NAME = 'featured-properties';

  /**
   * @var string
   */
  const SAVE_TAB_SESSION_VARIABLE_NAME = 'savetab';

  /**
   * @var string
   */
  const TAB_GET_PARAMETER_NAME = 'tab';

  /**
   * @var string
   */
  const FLOOR_PLAN_TAB_NAME = 'floor-plan';

  /**
   * @return string
   */
  public static function generalTabName(): string
  {
    return static::GENERAL_TAB_NAME;
  }

  /**
   * @return string
   */
  public static function reviewsTabName(): string
  {
    return static::REVIEWS_TAB_NAME;
  }

  /**
   * @return string
   */
  public static function policiesTabName(): string
  {
    return static::POLICIES_TAB_NAME;
  }

  /**
   * @return string
   */
  public static function amenitiesTabName(): string
  {
    return static::AMENITIES_TAB_NAME;
  }

  /**
   * @return string
   */
  public static function formsTabName(): string
  {
    return static::FORMS_TAB_NAME;
  }

  /**
   * @return string
   */
  public static function urgencyAlertTabName(): string
  {
    return static::URGENCY_ALERT_TAB_NAME;
  }

  /**
   * @return string
   */
  public static function featuredPropertiesTabName(): string
  {
    return static::FEATURED_PROPERTIES_TAB_NAME;
  }

  /**
   * @return string
   */
  public static function floorPlanTabName(): string
  {
    return static::FLOOR_PLAN_TAB_NAME;
  }

  /**
   * @return string
   */
  public static function saveTabSessionVariableName(): string
  {
    return static::SAVE_TAB_SESSION_VARIABLE_NAME;
  }

  /**
   * This will display a settings form.
   *
   * @see \Rezfusion\Registerer\PagesRegisterer
   * @see \Rezfusion\Registerer\SettingsRegisterer
   *
   * @return void
   */
  public function display(): void
  {
    if (!empty($_POST)) {
      $this->save($_POST);
    }
    print $this->template->render();
  }

  /**
   * @return string
   */
  public static function tabGetParameterName(): string
  {
    return static::TAB_GET_PARAMETER_NAME;
  }

  /**
   * Save the form we displayed on the page.
   * @param array $values
   * 
   * @return void
   */
  protected function save(array $values = []): void
  {
    switch ($_SESSION[static::saveTabSessionVariableName()]) {
      case static::generalTabName():
        $keys = [
          Options::componentsURL(),
          Options::environment(),
          Options::redirectUrls(),
          Options::syncItems(),
          Options::syncItemsPostType(),
          Options::customListingSlug(),
          Options::customPromoSlug(),
          Options::promoCodeFlagText(),
          Options::repositoryToken()
        ];
        break;
      case static::policiesTabName():
        $keys  = [
          Options::policiesGeneral(),
          Options::policiesPets(),
          Options::policiesPayment(),
          Options::policiesCancellation(),
          Options::policiesChanging(),
          Options::policiesInsurance(),
          Options::policiesCleaning()
        ];
        break;
      case static::amenitiesTabName():
        $keys = [
          Options::amenitiesFeatured(),
          Options::amenitiesGeneral()
        ];
        break;
      case static::formsTabName():
        $keys = [
          Options::reviewButtonText(),
          Options::reviewForm(),
          Options::inquiryButtonText(),
          Options::inquiryForm()
        ];
        break;
      case static::urgencyAlertTabName():
        $keys = [
          Options::urgencyAlertEnabled(),
          Options::urgencyAlertDaysThreshold(),
          Options::urgencyAlertMinimumVisitors(),
          Options::urgencyAlertHighlightedText(),
          Options::urgencyAlertText()
        ];
        break;
      case static::featuredPropertiesTabName():
        $keys = [
          Options::featuredPropertiesUseIcons(),
          Options::featuredPropertiesBedsLabel(),
          Options::featuredPropertiesBathsLabel(),
          Options::featuredPropertiesSleepsLabel(),
          Options::featuredPropertiesIds()
        ];
        break;
      case static::reviewsTabName():
        $keys = [
          Options::newReviewNotificationRecipients()
        ];
        break;
      case static::floorPlanTabName():
        $keys = [];
        break;
      default:
        break;
    }

    $values = (new ValuesCleanerFactory)->make()->clean($values);

    foreach ($keys as $key) {
      OptionManager::update($key, (isset($_POST[$key]) && !empty($_POST[$key])) ? $values[$key] : NULL);
    }

    OptionManager::update(Options::triggerRewriteFlush(), 1);

    add_action(Actions::adminNotices(), function () { ?>
      <div class="notice notice-success is-dismissible">
        <p><?php echo 'Settings saved.'; ?></p>
      </div>
<?php });
  }
}
