<?php

namespace Rezfusion\Tests\TestHelper;

use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Metas;
use Rezfusion\PostTypes;
use Rezfusion\Repository\ItemRepository;
use RuntimeException;

class PostHelper
{
    public static function getRecentPostId(): int
    {
        $items = (new ItemRepository((new API_ClientFactory())->make()))->getAllItems();
        $postId = intval(@$items[0]['post_id']);
        if (empty($postId))
            throw new RuntimeException("Invalid recent post id.");
        return $postId;
    }

    public static function getRecentPost(): object
    {
        $post = get_post(static::getRecentPostId());
        if (empty($post) || is_wp_error($post)) {
            throw new RuntimeException("Invalid recent post.");
        }
        return $post;
    }

    public static function publishedPropertiesPostsCount(): int
    {
        global $wpdb;
        return intval($wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(p.ID) FROM $wpdb->postmeta AS pm LEFT JOIN $wpdb->posts AS p ON p.id = pm.post_id WHERE pm.meta_key = %s AND pm.meta_value IS NOT NULL AND p.post_status = %s ORDER BY p.post_title ASC LIMIT 100", [
                Metas::itemId(),
                'publish'
            ])
        ));
    }

    public static function insertPromoPost($promoCode = '', array $propertiesPostsIds = [])
    {
        return wp_insert_post([
            'post_type' => PostTypes::promo(),
            'post_status' => 'publish',
            'post_title' => 'PromoTest',
            'meta_input' => [
                Metas::promoCodeValue() => $promoCode,
                Metas::promoListingValue() => $propertiesPostsIds
            ]
        ]);
    }
}
