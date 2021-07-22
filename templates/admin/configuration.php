<?php

/**
 * @file - Display the Rezfusion configuration admin page.
 *
 */

use Rezfusion\PostRecentVisits;
use Rezfusion\Shortcodes\UrgencyAlert;
use Rezfusion\Template;

if (isset($_GET['tab'])) {
  $_SESSION['savetab'] = $_GET['tab'];
} else {
  $_SESSION['savetab'] = 'general';
}
?>

<?php
function rezfusion_admin_tabs($current = 'general')
{
  $tabs = array(
    'general'   => 'General',
    'policies'  => 'Policies',
    'amenities' => 'Amenities',
    'forms'     => 'Forms',
    'urgency-alert' => 'Urgency Alert'
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
  <h1>Rezfusion Components</h1>

  <?php do_action('admin_notices'); ?>

  <?php isset($_GET['tab']) ? rezfusion_admin_tabs($_GET['tab']) : rezfusion_admin_tabs('general'); ?>

  <form method="post" action="/wp-admin/admin.php?page=rezfusion_components_config">
    <?php settings_fields('rezfusion-components'); ?>
    <?php do_settings_sections('rezfusion-components'); ?>
    <table class="form-table">
      <?php if (isset($_GET['tab'])) {
        $tab = $_GET['tab'];
      } else {
        $tab = 'general';
      }

      switch ($tab) {
        case 'general':
          include plugin_dir_path(__FILE__) . 'configuration-general.php';
          break;
        case 'policies':
          include plugin_dir_path(__FILE__) . 'configuration-policies.php';
          break;
        case 'amenities':
          include plugin_dir_path(__FILE__) . 'configuration-amenities.php';
          break;
        case 'forms':
          include plugin_dir_path(__FILE__) . 'configuration-forms.php';
          break;
        case 'urgency-alert':
          $Template = new Template('admin/configuration-urgency-alert.php', REZFUSION_PLUGIN_TEMPLATES_PATH);
          $prefix = 'rezfusion_hub_urgency_alert_';
          echo $Template->render([
            'urgencyAlertEnabled' => $prefix . 'enabled',
            'daysThreshold' => $prefix . 'days_threshold',
            'minimumVisitors' => $prefix . 'minimum_visitors',
            'highlightedText' => $prefix . 'highlighted_text',
            'text' => $prefix . "text",
            "defaultUrgencyText" => UrgencyAlert::defaultUrgencyText()
          ]);
          break;
      }
      ?>
    </table>
    <?php submit_button(); ?>
    <input type="hidden" name="rezfusion-settings-submit" value='Y'>
  </form>
</div>