<?php

namespace Rezfusion;

class UserRoles
{

    /**
     * @var string
     */
    const ADMINISTRATOR_ROLE = "administrator";

    /**
     * @var string
     */
    const EDITOR_ROLE = 'editor';

    /**
     * @return string
     */
    public static function administrator(): string
    {
        return static::ADMINISTRATOR_ROLE;
    }

    /**
     * @return string
     */
    public static function editor(): string
    {
        return static::EDITOR_ROLE;
    }

    /**
     * Check if user has all roles.
     * 
     * @param null|object $user
     * @param array $roles
     * 
     * @return bool
     */
    public static function userHasRoles($user = null, array $roles = []): bool
    {
        $total = count($roles);
        if ($total > 0 && !empty($user)) {
            $userRoles = (array) $user->roles;
            $checked = 0;
            foreach ($roles as $role) {
                if (in_array($role, $userRoles)) {
                    $checked++;
                }
            }
            if ($checked === $total)
                return true;
        }
        return false;
    }

    /**
     * Check if user has any of roles.
     * 
     * @param null|object $user
     * @param array $roles
     * 
     * @return bool
     */
    public static function userHasAnyRole($user = null, array $roles = []): bool
    {
        foreach ($roles as $role) {
            if (static::userHasRoles($user, [$role]) === true) {
                return true;
            }
        }
        return false;
    }
}
