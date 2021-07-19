<?php

/**
 * @file - Display the Rezfusion configuration admin page.
 *
 */

use Rezfusion\Factory\FeaturedPropertiesConfigurationTemplateVariablesFactory;
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
    'featured-properties' => 'Featured Properties'
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
        case 'featured-properties': {
            echo (new Template('configuration-featured-properties.php', plugin_dir_path(__FILE__)))
              ->render((new FeaturedPropertiesConfigurationTemplateVariablesFactory)->make());
            break;
          }
      }
      ?>
    </table>
    <?php submit_button(); ?>
    <input type="hidden" name="rezfusion-settings-submit" value='Y'>
  </form>
</div>