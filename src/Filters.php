<?php

namespace Rezfusion;

/**
 * @file Container for filters names.
 */
class Filters
{
    /**
     * @var string
     */
    const REVIEWS_ALLOWED_USER_ROLES = 'rezfusion_reviews_allowed_user_roles';

    /**
     * @var string
     */
    const PLUGIN_NAME = 'rezfusion_plugin_name';

    /**
     * @return string
     */
    public static function reviewsAllowedUserRoles(): string
    {
        return static::REVIEWS_ALLOWED_USER_ROLES;
    }

    /**
     * @param string $postType
     * 
     * @return string
     */
    public static function managePostTypePostsColumns($postType = ''): string
    {
        return "manage_{$postType}_posts_columns";
    }

    /**
     * @return string
     */
    public static function pluginName(): string
    {
        return static::PLUGIN_NAME;
    }

    /**
     * @param string $name
     * 
     * @return string
     */
    public static function variables($name = ''): string
    {
        return "variables_{$name}";
    }
}
