<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Options;
use Rezfusion\Partial;
use Rezfusion\Plugin;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Repository\LodgingProductRepository;
use Rezfusion\Template;
use Rezfusion\Templates;

class FeaturedProperties extends Shortcode
{

    /**
     * @var int
     */
    const MAX_PROPERTIES_COUNT = 6;

    /**
     * @return int
     */
    protected function maxPropertiesCount()
    {
        return static::MAX_PROPERTIES_COUNT;
    }

    /**
     * @var string
     */
    protected $shortcode = 'rezfusion-featured-properties';

    /**
     * @return string[]
     */
    protected function getPropertiesIds()
    {
        $propertiesIds = [];
        $optionValue = get_option(Options::featuredPropertiesIds(), 'rezfusion-featured-properties-ids');
        if (is_string($optionValue) && !empty($optionValue))
            $propertiesIds = json_decode(str_replace("\\", "", $optionValue), true);
        if (count($propertiesIds) === 0)
            $propertiesIds = (new ItemRepository(Plugin::apiClient()))->getAllItemsIds();
        return $propertiesIds;
    }

    /**
     * @param string[] $propertiesIds
     * @param int $max
     * 
     * @return string[]
     */
    protected function prepareRandomPropertiesIds(array $propertiesIds = [], $max = 6)
    {
        $randomizedPropertiesIds = [];
        while (count($propertiesIds) > 0) {
            $randomIndex = mt_rand(0, count($propertiesIds) - 1);
            $randomizedPropertiesIds[] = $propertiesIds[$randomIndex];
            array_splice($propertiesIds, $randomIndex, 1);
            if (count($randomizedPropertiesIds) === $max)
                break;
        }
        return $randomizedPropertiesIds;
    }

    /**
     * @return array
     */
    protected function prepareTemplateVariables()
    {
        $variables = [
            'properties' => $this->preparePropertiesData(
                $this->prepareRandomPropertiesIds($this->getPropertiesIds(), $this->maxPropertiesCount())
            ),
            'useIcons' => filter_var(get_option(Options::featuredPropertiesUseIcons()), FILTER_VALIDATE_BOOLEAN),
            'bathsLabel' => get_option(Options::featuredPropertiesBathsLabel()),
            'bedsLabel' => get_option(Options::featuredPropertiesBedsLabel()),
            'sleepsLabel' => get_option(Options::featuredPropertiesSleepsLabel()),
            'propertyDetailsPartial' => new Partial(Templates::propertyDetailsParial())
        ];

        /* Fix empty variables. */
        (empty($variables['bedsLabel'])) && $variables['bedsLabel'] = __('Beds');
        (empty($variables['bathsLabel'])) && $variables['bathsLabel'] = __('Baths');
        (empty($variables['sleepsLabel'])) && $variables['sleepsLabel'] = __('Sleeps');

        return $variables;
    }

    /**
     * @param object $lodgingProduct
     * 
     * @return array
     */
    protected function makePropertyDataFromLodgingProduct(object $lodgingProduct)
    {
        $image = $lodgingProduct->item->images[0];
        $imageUrl = '';
        foreach ($image->derivatives as $derivative) {
            if ($derivative->dimensions[0] === 300) {
                $imageUrl = $derivative->url;
                break;
            }
        }
        return [
            'id' => $lodgingProduct->item->id,
            'name' => $lodgingProduct->item->name,
            'url' => '',
            'baths' => $lodgingProduct->baths,
            'beds' => $lodgingProduct->beds,
            'sleeps' => $lodgingProduct->occ_total,
            'image_url' => $imageUrl,
            'image_title' => $image->title,
            'image_description' => $image->description,
        ];
    }

    /**
     * @param string[] $propertiesIds
     * 
     * @return array
     */
    public function getPostsIds(array $propertiesIds = [])
    {
        global $wpdb;
        return is_array(
            $items = $wpdb->get_results("SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = '" . ItemRepository::ITEM_META_KEY . "' AND meta_value IS NOT NULL AND meta_value IN (" . join(',', array_map(function ($item) {
                return "'$item'";
            }, $propertiesIds)) . ") LIMIT 100", ARRAY_A)
        ) ? $items : [];
    }

    /**
     * Builds map of properties ids and posts ids associated with them.
     * 
     * @param string[] $propertiesIds
     * 
     * @return array
     */
    protected function makePropertyIdAndPostIdMap(array $propertiesIds = [])
    {
        $postsIds = $this->getPostsIds($propertiesIds);
        return array_combine(array_column($postsIds, 'meta_value'), array_column($postsIds, 'post_id'));
    }

    /**
     * @param string[] $propertiesIds
     * 
     * @return array
     */
    protected function preparePropertiesData(array $propertiesIds = [])
    {
        $properties = [];
        if (count($propertiesIds)) {
            $Repository = new LodgingProductRepository(Plugin::apiClient(), get_rezfusion_option(Options::hubChannelURL()));
            $lodgingProducts = $Repository->findByIds($propertiesIds);
            $propertyIdAndPostIdMap = $this->makePropertyIdAndPostIdMap($propertiesIds);
            foreach ($lodgingProducts as $lodgingProduct) {
                $property = $this->makePropertyDataFromLodgingProduct($lodgingProduct);
                if (!empty($postId = $propertyIdAndPostIdMap[$lodgingProduct->item->id]))
                    $property['url'] = get_permalink($postId);
                $properties[] = $property;
            }
        }
        return $properties;
    }

    /**
     * @param array $atts
     * 
     * @return string
     */
    public function render($atts = []): string
    {
        return $this->template->render($this->prepareTemplateVariables());
    }
}
