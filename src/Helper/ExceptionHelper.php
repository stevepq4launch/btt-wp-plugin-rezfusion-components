<?php

namespace Rezfusion\Helper;

class ExceptionHelper
{
    public static function isWordpressError($wordpressError): bool
    {
        return is_wp_error($wordpressError);
    }

    public static function getMessagesFromWordpressError($wordpressError): array
    {
        if (static::isWordpressError($wordpressError)) {
            return $wordpressError->get_error_messages(null);
        }
        return [];
    }

    public static function makeMessageFromWordpressError($wordpressError): string
    {
        return join(' / ', static::getMessagesFromWordpressError($wordpressError));
    }

    public static function handleWordpressError($wordpressError): void
    {
        if (static::isWordpressError($wordpressError)) {
            throw new \Error(static::makeMessageFromWordpressError($wordpressError));
        }
    }
}
