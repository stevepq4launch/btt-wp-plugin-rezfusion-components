<?php

namespace Rezfusion\Factory;

use Puc_v4_Factory;
use Rezfusion\Options;
use Rezfusion\OptionsHandler;

class PluginUpdaterFactory
{

    /**
     * @var OptionsHandler
     */
    protected $OptionsHandler;

    /**
     * @param OptionsHandler $OptionsHandler
     */
    public function __construct(OptionsHandler $OptionsHandler)
    {
        $this->OptionsHandler = $OptionsHandler;
    }

    /**
     * @return Puc_v4p11_Plugin_UpdateChecker|Puc_v4p11_Theme_UpdateChecker|Puc_v4p11_Vcs_BaseChecker|null
     */
    public function make()
    {
        require REZFUSION_PLUGIN_PATH . '/vendor/autoload.php';

        $repositoryURL = $this->OptionsHandler->getOption(Options::repositoryURL());
        $repositoryToken = $this->OptionsHandler->getOption(Options::repositoryToken(), '');

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
