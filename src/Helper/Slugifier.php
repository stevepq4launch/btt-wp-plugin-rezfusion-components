<?php

namespace Rezfusion\Helper;

class Slugifier implements SlugifierInterface
{
    /**
     * @param string $slug
     * 
     * @return string
     */
    public function slugify($slug = ''): string
    {
        return trim(strtolower(preg_replace('~[^-\w]+~', '', $slug)));
    }
}
