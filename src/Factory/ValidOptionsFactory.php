<?php

namespace Rezfusion\Factory;

use Rezfusion\Options;

use function PHPSTORM_META\map;

class ValidOptionsFactory implements MakeableInterface
{
    /**
     * Creates an array of valid options names.
     * @return array
     */
    public function make(): array
    {
        return array_unique([
            Options::newReviewNotificationRecipients(),
            Options::promoCodeFlagText(),
            Options::customListingSlug(),
            Options::customPromoSlug(),
            Options::redirectUrls(),
            Options::syncItemsPostType(),
            Options::triggerRewriteFlush(),
            Options::featuredPropertiesIds(),
            Options::featuredPropertiesUseIcons(),
            Options::featuredPropertiesBathsLabel(),
            Options::featuredPropertiesBedsLabel(),
            Options::featuredPropertiesSleepsLabel(),
            Options::favoritesNamespace(),
            Options::reviewButtonText(),
            Options::urgencyAlertHighlightedText(),
            Options::urgencyAlertText(),
            Options::urgencyAlertEnabled(),
            Options::urgencyAlertDaysThreshold(),
            Options::urgencyAlertMinimumVisitors(),
            Options::amenitiesFeatured(),
            Options::amenitiesGeneral(),
            Options::dateFormat(),
            Options::reviewForm(),
            Options::inquiryButtonText(),
            Options::inquiryForm(),
            Options::repositoryToken(),
            Options::policiesGeneral(),
            Options::policiesPets(),
            Options::policiesPayment(),
            Options::policiesCancellation(),
            Options::policiesChanging(),
            Options::policiesInsurance(),
            Options::policiesCleaning()
        ]);
    }
}
