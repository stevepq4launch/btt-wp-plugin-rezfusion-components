<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Factory\PostRecentVisitsFactory;
use Rezfusion\Options;
use Rezfusion\PostRecentVisits;

class UrgencyAlert extends Shortcode
{

    /**
     * @inheritdoc
     */
    protected $shortcode = 'rezfusion-urgency-alert';

    /**
     * @var string
     */
    const VISITORS_COUNT_TAG = '[[visitorsCount]]';

    /**
     * @var string
     */
    const DEFAULT_HIGHLIGHTED_TEXT = "Popular";

    /**
     * @var string
     */
    const DEFAULT_URGENCY_TEXT = "Recently viewed by " . self::VISITORS_COUNT_TAG . " other travelers!";

    /**
     * @return string
     */
    public static function defaultUrgencyText()
    {
        return static::DEFAULT_URGENCY_TEXT;
    }

    /**
     * @return string
     */
    protected function prepareHighlightedText()
    {
        return !empty($text = get_rezfusion_option(Options::urgencyAlertHighlightedText())) ? $text : '';
    }

    /**
     * @return string
     */
    protected function getUrgencyText()
    {
        return !empty($text = get_rezfusion_option(Options::urgencyAlertText())) ? $text : static::DEFAULT_URGENCY_TEXT;
    }

    /**
     * @param string $text
     * @param mixed $visitorsCount
     * 
     * @return string
     */
    protected function prepareUrgencyText($text = '', $visitorsCount = 0)
    {
        return str_replace(static::VISITORS_COUNT_TAG, $visitorsCount, $text);
    }

    /**
     * @inheritdoc
     */
    public function render($atts = []): string
    {
        $finalAttributes = shortcode_atts(['postid' => get_the_ID()], $atts);
        $postId = $finalAttributes['postid'];
        $enabled = boolval(get_rezfusion_option(Options::urgencyAlertEnabled(), false));
        $minimumVisitors = intval(get_rezfusion_option(Options::urgencyAlertMinimumVisitors()));

        if ($enabled === false)
            return '';
        if (empty($postId))
            return "Rezfusion Urgency Alert: Post ID is required";
        if ($minimumVisitors < 1)
            return 'Rezfusion Urgency Alert: Minimum visitors value must be greater than 0.';

        $PostRecentVisits = (new PostRecentVisitsFactory())->make();
        $PostRecentVisits->update($postId);
        $visitorsCount = $PostRecentVisits->getRecentVisitsCount($postId) - 1;

        return ($visitorsCount >= $minimumVisitors)
            ? $this->template->render([
                'highlightedText' => $this->prepareHighlightedText(),
                'urgencyText' => $this->prepareUrgencyText($this->getUrgencyText(), $visitorsCount),
                'visitorsCount' => $visitorsCount
            ])
            : '';
    }
}
