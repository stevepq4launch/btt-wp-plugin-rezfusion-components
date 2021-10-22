<?php

namespace Rezfusion\Helper;

class OptionManager
{
    /**
     * @param string $option
     * @param null $default
     * 
     * @return [type]
     */
    public static function get($option = '', $default = null)
    {
        return get_option($option, $default);
    }

    /**
     * @param string $option
     * @param mixed $value
     * 
     * @return bool
     */
    public static function update(string $option = '', $value): bool
    {
        return update_option($option, $value);
    }

    /**
     * @param string $option
     * 
     * @return bool
     */
    public static function delete(string $option = ''): bool
    {
        return delete_option($option);
    }
}
