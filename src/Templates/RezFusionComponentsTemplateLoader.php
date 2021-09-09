<?php


class RezFusionComponentsTemplateLoader extends Gamajo_Template_Loader
{
  /**
   * Prefix for filter names.
   *
   * @since 1.0.0
   * @type string
   */
  protected $filter_prefix = "rzf_comp";

  /**
   * Directory name where custom templates for this plugin should be found in the theme.
   *
   * @since 1.0.0
   * @type string
   */
  protected $theme_template_directory = "rezfusion";

  /**
   * Reference to the root directory path of this plugin.
   *
   * @since 1.0.0
   * @type string
   */
  protected $plugin_directory = REZFUSION_PLUGIN_PATH;

}
