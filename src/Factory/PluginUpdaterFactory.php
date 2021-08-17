<?php

namespace Rezfusion\Factory;

use Puc_v4_Factory;
use Rezfusion\PluginConfiguration;

class PluginUpdaterFactory
{

    /**
     * @var PluginConfiguration
     */
    protected $PluginConfiguration;

    /**
     * @param PluginConfiguration $PluginConfiguration
     */
    public function __construct(PluginConfiguration $PluginConfiguration)
    {
        $this->PluginConfiguration = $PluginConfiguration;
    }

    /**
     * @return Puc_v4p11_Plugin_UpdateChecker|Puc_v4p11_Theme_UpdateChecker|Puc_v4p11_Vcs_BaseChecker|null
     */
    public function make()
    {
        require REZFUSION_PLUGIN_PATH . '/vendor/autoload.php';

        $repositoryURL = $this->PluginConfiguration->repositoryURL();
        $repositoryToken = $this->PluginConfiguration->repositoryToken();

        if (empty($repositoryURL) || empty($repositoryToken))
            return null;

        $PluginUpdater = Puc_v4_Factory::buildUpdateChecker(
            $repositoryURL,
            REZFUSION_PLUGIN_PATH . 'rezfusion-components.php',
            'rezfusion-components'
        );
        $PluginUpdater->getVcsApi()->enableReleaseAssets();
        $PluginUpdater->setAuthentication($repositoryToken);
        return $PluginUpdater;
    }
}
