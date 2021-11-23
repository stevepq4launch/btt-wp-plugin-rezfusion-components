<?php

/**
 * @file - Display the Rezfusion configuration admin page.
 *
 */

use Rezfusion\Factory\FeaturedPropertiesConfigurationTemplateVariablesFactory;
use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\Options;
use Rezfusion\Pages\Admin\ConfigurationPage;
use Rezfusion\Shortcodes\UrgencyAlert;
use Rezfusion\Plugin;
use Rezfusion\Template;
use Rezfusion\Templates;

$_SESSION[ConfigurationPage::saveTabSessionVariableName()] = (isset($_GET[ConfigurationPage::tabGetParameterName()])) ? $_GET[ConfigurationPage::tabGetParameterName()] : ConfigurationPage::generalTabName();
?>

<?php
function rezfusion_admin_tabs($current = ConfigurationPage::GENERAL_TAB_NAME)
{
  $tabs = array(
    ConfigurationPage::generalTabName()   => 'General',
    ConfigurationPage::policiesTabName()  => 'Policies',
    ConfigurationPage::amenitiesTabName() => 'Amenities',
    ConfigurationPage::formsTabName()     => 'Forms',
    ConfigurationPage::urgencyAlertTabName() => 'Urgency Alert',
    ConfigurationPage::featuredPropertiesTabName() => 'Featured Properties',
    ConfigurationPage::reviewsTabName() => 'Reviews'
  );

  echo '<div id="icon-themes" class="icon32"><br></div>';
  echo '<h2 class="nav-tab-wrapper">';
  foreach ($tabs as $tab => $name) {
    $class = ($tab == $current) ? ' nav-tab-active' : '';
    echo "<a class='nav-tab$class' href='?page=rezfusion_components_config&tab=$tab'>$name</a>";
  }
  echo '</h2>';
}
?>

<div class="wrap">
  <h1><?php echo sprintf('%s %s', Plugin::getInstance()->getPluginName(), __('Components')); ?></h1>

  <?php do_action('admin_notices'); ?>

  <?php isset($_GET[ConfigurationPage::tabGetParameterName()]) ? rezfusion_admin_tabs($_GET[ConfigurationPage::tabGetParameterName()]) : rezfusion_admin_tabs(ConfigurationPage::generalTabName()); ?>

  <form id="rezfusion-configuration-form" method="post" action="/wp-admin/admin.php?page=rezfusion_components_config" nonce="<?php echo esc_attr(wp_create_nonce('wp_rest')); ?>">
    <?php settings_fields('rezfusion-components'); ?>
    <?php do_settings_sections('rezfusion-components'); ?>
    <table class="form-table">
      <?php
      $tab = (isset($_GET[ConfigurationPage::tabGetParameterName()])) ? $_GET[ConfigurationPage::tabGetParameterName()] : ConfigurationPage::generalTabName();

      switch ($tab) {
        case ConfigurationPage::generalTabName():
          echo (new Template(Templates::generalConfigurationTemplate(), REZFUSION_PLUGIN_TEMPLATES_PATH))->render([
            'rezfusion_hub_folder_value' => esc_attr(get_rezfusion_option(Options::componentsURL())),
            'isProdEnv' => get_rezfusion_option(Options::environment()) === HubConfigurationProvider::getInstance()->productionEnvironment(),
            'isDevEnv' => get_rezfusion_option(Options::environment()) === HubConfigurationProvider::getInstance()->developmentEnvironment(),
          ]);
          break;
        case ConfigurationPage::policiesTabName():
          include REZFUSION_PLUGIN_TEMPLATES_PATH . '/' . Templates::policiesConfigurationTemplate();
          break;
        case ConfigurationPage::amenitiesTabName():
          include REZFUSION_PLUGIN_TEMPLATES_PATH .  '/' . Templates::amenitiesConfigurationTemplate();
          break;
        case ConfigurationPage::formsTabName():
          include REZFUSION_PLUGIN_TEMPLATES_PATH .  '/' . Templates::formsConfigurationTemplate();
          break;
        case ConfigurationPage::urgencyAlertTabName():
          echo (new Template(Templates::urgencyAlertConfigurationTemplate(), REZFUSION_PLUGIN_TEMPLATES_PATH))->render([
            'urgencyAlertEnabled' => Options::urgencyAlertEnabled(),
            'daysThreshold' => Options::urgencyAlertDaysThreshold(),
            'minimumVisitors' => Options::urgencyAlertMinimumVisitors(),
            'highlightedText' => Options::urgencyAlertHighlightedText(),
            'text' => Options::urgencyAlertText(),
            "defaultUrgencyText" => UrgencyAlert::defaultUrgencyText()
          ]);
          break;
        case ConfigurationPage::featuredPropertiesTabName(): {
            echo (new Template(Templates::featuredPropertiesConfigurationTemplate(), REZFUSION_PLUGIN_TEMPLATES_PATH))
              ->render((new FeaturedPropertiesConfigurationTemplateVariablesFactory)->make());
            break;
          }
        case ConfigurationPage::reviewsTabName(): {
            $newReviewNotificationRecipientsOption = Options::newReviewNotificationRecipients();
            echo (new Template(Templates::reviewsConfigurationPage(), REZFUSION_PLUGIN_TEMPLATES_PATH))->render([
              'newReviewNotificationRecipientsOption' => $newReviewNotificationRecipientsOption,
              'newReviewNotificationRecipientsValue' => esc_attr(get_rezfusion_option($newReviewNotificationRecipientsOption))
            ]);
          }
      }
      ?>
    </table>
    <?php submit_button(); ?>
    <input type="hidden" name="rezfusion-settings-submit" value='Y'>
  </form>
</div>