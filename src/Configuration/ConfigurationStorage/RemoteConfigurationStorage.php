<?php

namespace Rezfusion\Configuration\ConfigurationStorage;

use Error;
use stdClass;

/**
 * @file Provides configuration from remote endpoint.
 */
class RemoteConfigurationStorage implements ConfigurationStorageInterface
{

    /**
     * @var string
     */
    protected $URL;

    /**
     * @var string
     */
    protected $HubConfigurationClass;

    /**
     * @param string $URL
     * @param string $HubConfigurationClass
     */
    public function __construct($URL = '', $HubConfigurationClass = '')
    {
        $this->URL = $URL;
        $this->HubConfigurationClass = $HubConfigurationClass;
    }

    /**
     * @return mixed
     */
    public function loadConfiguration()
    {
        $configuration = new stdClass();

        if (empty($this->URL)) {
          add_action( 'admin_notices', function ()
          {
            ?>
              <div class="notice notice-error is-dismissible">
                <p><?php _e('No hub configuration available.&nbsp;&nbsp;Set components URL <a href="/wp-admin/admin.php?page=rezfusion_components_config">here</a>.', 'rezfusion-components') ?></p>
              </div>
            <?php
          } );
        }

        $remoteData = !empty($this->URL) ? file($this->URL, FILE_SKIP_EMPTY_LINES) : NULL ;
        if (!@empty($remoteData[0])) {
            preg_match('/JSON.parse\(\'(.*)\'\);\n/', $remoteData[0], $match);
            if (!@empty($match[1])) {

                $configuration->hub_configuration = json_decode(stripslashes($match[1]));
                $themeURL = '';
                $fontsURL = '';

                // Add theme URL.
                foreach ($remoteData as $key => $value) {
                    preg_match('~https://rezfusion-components-storage.*\.css~', $value, $themeURL_Match);
                    if (!empty($themeURL_Match)) {
                        $themeURL .= $themeURL_Match[0];
                        break;
                    }
                }
                $configuration->{$this->HubConfigurationClass::themeURL_Key()} = $themeURL;

                // Add fonts URL.                
                foreach ($remoteData as $key => $value) {
                    preg_match('~href = \'(https://fonts\.googleapis.*)\';~', $value, $fontsURL_Match);
                    if (!empty($fontsURL_Match)) {
                        $fontsURL = $fontsURL_Match[1];
                        break;
                    }
                }
                $configuration->{$this->HubConfigurationClass::fontsURL_Key()} = $fontsURL;
            }
        }

        return $configuration;
    }

    /**
     * @param mixed $configuration
     */
    public function saveConfiguration($configuration)
    {
    }
}
