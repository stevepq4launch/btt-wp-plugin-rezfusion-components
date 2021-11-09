<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Helper\ReviewsSorter;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Repository\HubReviewRepository;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Repository\ReviewRepository;

class Reviews extends Shortcode
{

    /**
     * @inheritdoc
     */
    protected $shortcode = 'rezfusion-reviews';

    /**
     * @inheritdoc
     */
    public function render($atts = []): string
    {
        $atts = shortcode_atts([
            'postid' => get_the_ID()
        ], $atts);

        if (empty($atts['postid']))
            return "Post ID is required to show reviews.";

        wp_register_script('rezfusion-reviews-modal-handler-js', plugin_dir_url(REZFUSION_PLUGIN) . '/assets/js/rezfusion-reviews-modal-handler.js');
        wp_enqueue_script('rezfusion-reviews-modal-handler-js');

        $reviewsCollection = [];
        $localReviews = [];
        $hubReviews = [];

        /* Fetch local reviews. */
        $LocalReviewRepository = new ReviewRepository(Plugin::apiClient());
        $localReviews = $LocalReviewRepository->getReviews($atts['postid'], 1);

        /* Fetch reviews from hub. */
        $propertyKey = (new ItemRepository(Plugin::apiClient()))->getPropertyKeyByPostId($atts['postid']);
        if (!empty($propertyKey)) {
            $HubReviewRepository = new HubReviewRepository(Plugin::apiClient(), get_rezfusion_option(Options::hubChannelURL()));
            $hubReviews = $HubReviewRepository->getReviews([$propertyKey]);
        }

        $reviewsCollection = array_merge($localReviews, $hubReviews);
        (new ReviewsSorter)->sortByStayDate($reviewsCollection);

        foreach ($reviewsCollection as $Review) {
            $reviews[] = $Review->toArray();
        }

        return $this->template->render([
            'reviews' => $reviews
        ]);
    }
}
