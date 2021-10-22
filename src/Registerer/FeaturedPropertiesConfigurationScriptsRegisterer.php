<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Assets;
use Rezfusion\Helper\AssetsRegistererInterface;

class FeaturedPropertiesConfigurationScriptsRegisterer implements RegistererInterface
{
    /**
     * @var AssetsRegistererInterface
     */
    private $AssetsRegisterer;

    /**
     * @param AssetsRegistererInterface $AssetsRegisterer
     */
    public function __construct(AssetsRegistererInterface $AssetsRegisterer)
    {
        $this->AssetsRegisterer = $AssetsRegisterer;
    }

    /**
     * Enqueue required styles and scripts for "Featured Properties" component.
     * @inheritdoc
     */
    public function register(): void
    {
        add_action(Actions::adminEnqueueScripts(), function () {
            $this->AssetsRegisterer->handleStyle(Assets::featuredPropertiesStyle());
            $this->AssetsRegisterer->handleScript(Assets::featuredPropertiesConfigurationComponentHandlerScript(), [], false, false);
        });
    }
}
