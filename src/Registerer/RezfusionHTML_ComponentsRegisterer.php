<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Assets;
use Rezfusion\Helper\AssetsRegistererInterface;

class RezfusionHTML_ComponentsRegisterer implements RegistererInterface
{

    /**
     * @var AssetsRegistererInterface
     */
    protected $AssetsRegisterer;

    /**
     * @param AssetsRegistererInterface $AssetsRegisterer
     */
    public function __construct(AssetsRegistererInterface $AssetsRegisterer)
    {
        $this->AssetsRegisterer = $AssetsRegisterer;
    }

    private function enqueueScripts()
    {
        $this->AssetsRegisterer->handleStyle(Assets::rezfusionStarsRatingStyle());
        $this->AssetsRegisterer->handleScript(Assets::rezfusionStarsRatingScript(), [], false, true);
        $this->AssetsRegisterer->handleStyle(Assets::rezfusionFieldsValidationStyle());
        $this->AssetsRegisterer->handleScript(Assets::rezfusionFieldsValidationScript(), [], false, true);
        $this->AssetsRegisterer->handleStyle(Assets::rezfusionModalStyle());
        $this->AssetsRegisterer->handleScript(Assets::rezfusionModalScript(), [], false, true);
        $this->AssetsRegisterer->handleScript(Assets::rezfusionReviewSubmitFormScript(), [], false, true);
        $this->AssetsRegisterer->handleScript(Assets::rezfusionScript(), [], false, true);
    }

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        $enqueueScripts = function () {
            $this->enqueueScripts();
        };
        add_action(Actions::enqueueScripts(), $enqueueScripts);
        add_action(Actions::adminEnqueueScripts(), $enqueueScripts);
    }
}
