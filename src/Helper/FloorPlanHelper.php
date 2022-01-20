<?php

namespace Rezfusion\Helper;

use InvalidArgumentException;
use Rezfusion\Repository\FloorPlanRepository;
use RuntimeException;

/**
 * @file Provides method for handling property floor plan / virtual tour.
 */
class FloorPlanHelper
{
    const TRUPLACE_PROVIDER = 'truplace';

    const TRUPLACE_URL = 'tour.truplace.com';

    const MATTERPORT_PROVIDER = 'matterport';

    const MATTERPORT_URL = 'matterport.com';

    const OTHER_PROVIDER = 'other';

    const TRUPLACE_LINK_WIDGET_SCRIPT = 'https://tour.truplace.com/include/linkwidget.js';

    /**
     * @var AssetsRegisterer
     */
    private $AssetsRegisterer;

    /**
     * @var FloorPlanRepository
     */
    private $FloorPlanRepository;

    /**
     * @param AssetsRegisterer $AssetsRegisterer
     * @param FloorPlanRepository $FloorPlanRepository
     */
    public function __construct(AssetsRegisterer $AssetsRegisterer, FloorPlanRepository $FloorPlanRepository)
    {
        $this->AssetsRegisterer = $AssetsRegisterer;
        $this->FloorPlanRepository = $FloorPlanRepository;
    }

    public static function truplaceProvider(): string
    {
        return static::TRUPLACE_PROVIDER;
    }

    public static function matterportProvider(): string
    {
        return static::MATTERPORT_PROVIDER;
    }

    public static function otherProvider(): string
    {
        return static::OTHER_PROVIDER;
    }

    public static function truplaceURL(): string
    {
        return static::TRUPLACE_URL;
    }

    public static function matterportURL(): string
    {
        return static::MATTERPORT_PROVIDER;
    }

    public static function truplaceLinkWidgetURL(): string
    {
        return static::TRUPLACE_LINK_WIDGET_SCRIPT;
    }

    public function resolveProviderFromURL($url = ''): string
    {
        if (empty($url)) {
            throw new InvalidArgumentException('URL is invalid.');
        }
        if (stripos($url, static::truplaceProvider())) {
            return static::truplaceProvider();
        } elseif (stripos($url, static::matterportProvider())) {
            return static::matterportProvider();
        }
        return static::otherProvider();
    }

    public function findFloorPlanURL($propertyKey = '', $postID = 0): string
    {
        // First try overridden URL.
        $floorPlanData = $this->FloorPlanRepository->findOneByPostID($postID);
        if (is_array($floorPlanData) && isset($floorPlanData['url'])) {
            return $floorPlanData['url'];
        }
        // Try URL directly from hub.
        if (!empty($propertyKey)) {
            $url = $this->FloorPlanRepository->findURL_ForProperty($propertyKey);
            if (!empty($url)) {
                return $url;
            }
        }
        return '';
    }

    public function registerAssets($provider = ''): void
    {
        if ($provider === static::truplaceProvider()) {
            $this->AssetsRegisterer->handleScriptURL(static::truplaceLinkWidgetURL());
        }
    }

    public function parseURL($url = '', $provider = ''): string
    {
        if (empty($url)) {
            throw new InvalidArgumentException('URL is invalid.');
        }
        if (empty($provider)) {
            throw new InvalidArgumentException('Provider is invalid.');
        }
        if ($provider === static::truplaceProvider()) {
            return parse_url($url)['path'];
        }
        return $url;
    }

    public function providerRequiresElementSelector($provider = ''): bool
    {
        if (empty($provider)) {
            throw new InvalidArgumentException('Provider is invalid.');
        }
        if ($provider === static::truplaceProvider()) {
            return true;
        }
        return false;
    }

    /**
     * Check if post has floor plan URL.
     * @param int $postID
     * 
     * @return bool
     */
    public function hasFloorPlanURL($postID = 0): bool
    {
        return $this->FloorPlanRepository->hasFloorPlan($postID);
    }

    /**
     * @param string $propertyKey
     * @param int $postID
     * 
     * @return array
     */
    public function prepareShortcodeAttributes($propertyKey = '', $postID = 0): array
    {
        $url = '';
        $provider = '';

        if (empty($propertyKey) && empty($postID)) {
            throw new RuntimeException('Empty post ID and property key.');
        }

        $url = $this->findFloorPlanURL($propertyKey, $postID);
        if (!empty($url)) {
            $provider = $this->resolveProviderFromURL($url);
        }

        if (empty($url) || empty($provider)) {
            return [];
        }

        $this->registerAssets($provider);
        $url = $this->parseURL($url, $provider);

        return [
            'provider' => $provider,
            'url' => $url
        ];
    }
}
