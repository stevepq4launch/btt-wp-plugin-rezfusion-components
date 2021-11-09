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
     * @return string
     */
    public static function reviewsAllowedUserRoles(): string
    {
        return static::REVIEWS_ALLOWED_USER_ROLES;
    }
}
