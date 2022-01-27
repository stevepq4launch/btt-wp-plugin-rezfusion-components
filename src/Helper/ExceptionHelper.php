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
        $messages = [];
        $key = 'errors';
        if (is_object($wordpressError) && property_exists($wordpressError, $key)) {
            foreach ($wordpressError->$key as $errorName => $errorDescription) {
                $messages[] = (is_array($errorDescription) && isset($errorDescription[0])) ? $errorDescription[0] : $errorName;
            }
        }
        return $messages;
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
