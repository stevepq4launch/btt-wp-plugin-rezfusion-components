<?php

namespace Rezfusion\Factory;

use Rezfusion\Helper\AssetsRegistererInterface;
use Rezfusion\Options;
use Rezfusion\OptionsHandler;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\Registerer\AutomaticHubDataSynchronizationRegisterer;
use Rezfusion\Registerer\ControllersRegisterer;
use Rezfusion\Registerer\DelayedRewriteFlushRegisterer;
use Rezfusion\Registerer\FeaturedPropertiesConfigurationScriptsRegisterer;
use Rezfusion\Registerer\ComponentsBundleRegisterer;
use Rezfusion\Registerer\FontsRegisterer;
use Rezfusion\Registerer\FunctionsRegisterer;
use Rezfusion\Registerer\GetOptionFiltersRegisterer;
use Rezfusion\Registerer\PagesRegisterer;
use Rezfusion\Registerer\PluginUpdateRegisterer;
use Rezfusion\Registerer\PostTypesRegisterer;
use Rezfusion\Registerer\PropertyPage404FixRegisterer;
use Rezfusion\Registerer\RegisterersContainer;
use Rezfusion\Registerer\RewriteTagsRegisterer;
use Rezfusion\Registerer\RezfusionHTML_ComponentsRegisterer;
use Rezfusion\Registerer\SessionRegisterer;
use Rezfusion\Registerer\SettingsRegisterer;
use Rezfusion\Registerer\ShortcodesRegisterer;
use Rezfusion\Registerer\TemplateRedirectRegisterer;

class RegisterersContainerFactory
{
    /**
     * @var AssetsRegistererInterface
     */
    private $AssetsRegisterer;

    /**
     * @var OptionsHandler
     */
    private $OptionsHandler;

    /**
     * @param AssetsRegistererInterface $AssetsRegisterer
     * @param OptionsHandler $OptionsHandler
     */
    public function __construct(AssetsRegistererInterface $AssetsRegisterer, OptionsHandler $OptionsHandler)
    {
        $this->AssetsRegisterer = $AssetsRegisterer;
        $this->OptionsHandler = $OptionsHandler;
    }

    /**
     * Creates container with default set of registerers.
     * @return RegisterersContainer
     */
    public function make(): RegisterersContainer
    {
        return new RegisterersContainer([
            new FunctionsRegisterer(),
            new PostTypesRegisterer(),
            new ShortcodesRegisterer(),
            new RewriteTagsRegisterer(),
            new DelayedRewriteFlushRegisterer(),
            new PagesRegisterer($this->AssetsRegisterer),
            new SettingsRegisterer(),
            new TemplateRedirectRegisterer(),
            new ComponentsBundleRegisterer($this->AssetsRegisterer, $this->OptionsHandler),
            new RezfusionHTML_ComponentsRegisterer($this->AssetsRegisterer),
            new FontsRegisterer($this->AssetsRegisterer),
            new SessionRegisterer(),
            new FeaturedPropertiesConfigurationScriptsRegisterer($this->AssetsRegisterer),
            new ControllersRegisterer(),
            new PluginUpdateRegisterer($this->OptionsHandler),
            new PropertyPage404FixRegisterer(new API_ClientFactory),
            new AutomaticHubDataSynchronizationRegisterer(),
            new GetOptionFiltersRegisterer($this->OptionsHandler, Options::hubConfigurationOptions())
        ]);
    }
}
