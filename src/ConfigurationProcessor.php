<?php

namespace Rezfusion;

use Rezfusion\Configuration\HubConfiguration;

class ConfigurationProcessor
{
    /**
     * @param HubConfiguration $HubConfiguration
     * 
     * @return HubConfiguration
     */
    public function process(HubConfiguration $HubConfiguration): HubConfiguration
    {
        /* Filter properties by categories (amenities, locations, etc.) for taxonomy-type page. */
        if (is_tax()) {
            $meta = get_term_meta(get_queried_object()->term_id);
            $HubConfiguration->setValue(
                'hub_configuration.settings.components.SearchProvider.filters.categoryFilter.categories',
                [
                    'cat_id' => intval($meta[Metas::categoryId()][0]),
                    'values' => array_map(function ($value) {
                        return intval($value);
                    }, $meta[Metas::categoryValueId()]),
                    'operator' => 'AND'
                ]
            );
        }

        /* Filter properties by keys associated with promo-type post. */
        if (get_post_type() === PostTypes::promo()) {
            $promoIds = [];
            foreach (get_post_meta(get_post()->ID, Metas::promoListingValue())[0] as $listing) {
                $meta = get_post_meta($listing);
                if (!empty($meta)) {
                    $promoIds[] = $meta[Metas::itemId()][0];
                }
            }
            $HubConfiguration->setValue('hub_configuration.settings.components.SearchProvider.filters.itemIds', $promoIds);
        }

        return $HubConfiguration;
    }
}
