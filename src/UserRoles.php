<?php

namespace Rezfusion;

class UserRoles
{

    /**
     * @var string
     */
    const ADMINISTRATOR_ROLE = "administrator";

    /**
     * @return string
     */
    public static function administrator(): string
    {
        return static::ADMINISTRATOR_ROLE;
    }
}
