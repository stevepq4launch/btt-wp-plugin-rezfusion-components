<?php

namespace Rezfusion\Helper;

/**
 * Renders stars rating HTML.
 * 
 * (!) This should be consistent with *rezfusionStarsRating* JavaScript component.
 */
class StarsRatingRenderer
{

    /**
     * @var string
     */
    const BASE_CLASS_NAME = 'rezfusion-stars-rating';

    /**
     * @var string
     */
    const STAR_CLASS_NAME = self::BASE_CLASS_NAME . '__star';

    /**
     * @var string
     */
    const ACTIVE_STAR_CLASS_NAME = self::STAR_CLASS_NAME . '--active';

    /**
     * @var string
     */
    const INACTIVE_STAR_CLASS_NAME = self::STAR_CLASS_NAME . '--inactive';

    /**
     * @var string
     */
    const ACTIVE_STAR_SYMBOL = "&#9733;";

    /**
     * @var string
     */
    const INACTIVE_STAR_SYMBOL = "&#9734;";

    /**
     * @var int
     */
    protected $maxRating = 5;

    /**
     * @param int $maxRating
     */
    public function __construct($maxRating = 5)
    {
        $this->maxRating = $maxRating;
    }

    /**
     * Renders rating as *stars*.
     * 
     * @param int $rating
     * 
     * @return string
     */
    public function render($rating = 0)
    {
        $content = '<div class="' . static::BASE_CLASS_NAME . '">';
        for ($i = 0; $i < $this->maxRating; $i++) {
            $symbol = $i < $rating ? static::ACTIVE_STAR_SYMBOL : static::INACTIVE_STAR_SYMBOL;
            $className = static::STAR_CLASS_NAME . ' ' . static::STAR_CLASS_NAME . '--' . ($i < $rating ? "active" : "inactive");
            $content .= '<span class="' . $className . '">' . $symbol . '</span>';
        }
        $content .= "</div>";
        return $content;
    }
}
