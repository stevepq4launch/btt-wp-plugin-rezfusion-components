<?php

/**
 * Helper function for retrieving plugin options values.
 * 
 * @param string $option
 * @param null $default
 * 
 * @return mixed
 */
function get_rezfusion_option($option = '', $default = null)
{
    global $rezfusion;
    return $rezfusion->getOption($option, $default);
}
