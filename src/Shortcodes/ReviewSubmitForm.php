<?php

namespace Rezfusion\Shortcodes;

class ReviewSubmitForm extends Shortcode
{

    /**
     * @inheritdoc
     */
    protected $shortcode = 'rezfusion-review-submit-form';

    public function render($atts = []): string
    {
        $atts = shortcode_atts([
            'addReviewButtonText' => __(get_option('rezfusion_hub_review_btn_text')) ?: "Add a Review",
            'postid' => ''
        ], $atts);

        if (empty($atts['postid']))
            return "Post ID is required to show reviews.";

        return $this->template->render($atts);
    }
}
