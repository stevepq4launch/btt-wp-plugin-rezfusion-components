<?php

namespace Rezfusion\Registerer;

class RegistererNameGetter
{
    /**
     * @param RegistererInterface $Registerer
     * 
     * @return string
     */
    public static function get(RegistererInterface $Registerer): string
    {
        return get_class($Registerer);
    }
}
