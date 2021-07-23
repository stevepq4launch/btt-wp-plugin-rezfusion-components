<?php

namespace Rezfusion;

class Templates
{

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_TEMPLATE = "vr-featured-properties.php";

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_CONFIGURATION_TEMPLATE = 'configuration-featured-properties.php';

    /**
     * @return string
     */
    public static function featuredPropertiesTemplate()
    {
        return static::FEATURED_PROPERTIES_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesConfigurationTemplate()
    {
        return static::FEATURED_PROPERTIES_CONFIGURATION_TEMPLATE;
    }
}
