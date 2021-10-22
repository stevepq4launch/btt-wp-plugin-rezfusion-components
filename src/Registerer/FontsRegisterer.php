<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Helper\AssetsRegistererInterface;

class FontsRegisterer implements RegistererInterface
{
    /**
     * @var string
     */
    const FONTS_URL = 'https://use.fontawesome.com/releases/v5.15.1/css/all.css';

    /**
     * @var string
     */
    const FONTS_VERSION = '5.15.1';

    /**
     * @var string
     */
    const FONTS_MEDIA = 'all';

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
     * @inheritdoc
     */
    public function register(): void
    {
        add_action(Actions::adminEnqueueScripts(), function () {
            $this->AssetsRegisterer->handleStyleURL(static::FONTS_URL, [], static::FONTS_VERSION, static::FONTS_MEDIA);
        });
    }
}
