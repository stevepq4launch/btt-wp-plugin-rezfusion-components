<?php

namespace Rezfusion\Shortcodes;

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
        return !empty($text = get_option('rezfusion_hub_urgency_alert_highlighted_text')) ? $text : '';
    }

    /**
     * @return string
     */
    protected function getUrgencyText()
    {
        return !empty($text = get_option('rezfusion_hub_urgency_alert_text')) ? $text : static::DEFAULT_URGENCY_TEXT;
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
        $finalAttributes = shortcode_atts(['postid' => null], $atts);
        $postId = $finalAttributes['postid'];
        $enabled = boolval(get_option('rezfusion_hub_urgency_alert_enabled', false));
        $daysThreshold = intval(get_option('rezfusion_hub_urgency_alert_days_threshold'));
        $minimumVisitors = intval(get_option('rezfusion_hub_urgency_alert_minimum_visitors'));

        if ($enabled === false)
            return '';
        if (empty($postId))
            return "Rezfusion Urgency Alert: Post ID is required";
        if ($minimumVisitors < 1)
            return 'Rezfusion Urgency Alert: Minimum visitors value must be greater than 0.';
        if ($daysThreshold < 1)
            return 'Rezfusion Urgency Alert: Days threshold value must be greater than 0.';

        $PostRecentVisits = new PostRecentVisits($daysThreshold);
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
