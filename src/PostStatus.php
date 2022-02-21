<?php

namespace Rezfusion;

class PostStatus
{
    /**
     * @return string
     */
    public static function publishStatus(): string
    {
        return 'publish';
    }

    /**
     * @return string
     */
    public static function draftStatus(): string
    {
        return 'draft';
    }

    /**
     * @return string
     */
    public static function trashStatus(): string
    {
        return 'trash';
    }
}
