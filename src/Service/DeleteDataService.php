<?php

namespace Rezfusion\Service;

use Rezfusion\Metas;
use Rezfusion\PostRecentVisits;
use Rezfusion\PostTypes;
use Rezfusion\Taxonomies;
use Rezfusion\Tests\TestHelper\TestHelper;

/**
 * @file Deletes all synced data.
 * 
 * (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!)
 * This class should NOT be used on production environment.
 * (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!) (!)
 */
class DeleteDataService implements RunableInterface
{
    /**
     * @var bool
     */
    private static $LOCKED = true;

    /**
     * Unlock functionality.
     * 
     * @return void
     */
    public static function unlock(): void
    {
        static::$LOCKED = false;
    }

    /**
     * Lock functionality.
     * 
     * @return void
     */
    public static function lock(): void
    {
        static::$LOCKED = true;
    }

    /**
     * @return int|bool
     */
    public function deleteReviews()
    {
        global $wpdb;
        $field = 'comment_ID';
        $ids = wp_list_pluck($wpdb->get_results(
            $wpdb->prepare("SELECT $field FROM $wpdb->comments WHERE comment_type = '%s'", ['rezfusion-review'])
        ), $field);
        if (is_array($ids) && count($ids)) {
            foreach ($ids as $id) {
                wp_delete_comment($id, true);
            }
        }
    }

    /**
     * Delete all synced data.
     * 
     * @return void
     */
    public function run(): void
    {
        if (static::$LOCKED === true) {
            throw new \Error("DeleteDataService is locked.");
        }

        global $wpdb;

        /* Delete posts. */
        $query = new \WP_Query(array(
            'post_type' => [PostTypes::listing(), PostTypes::promo()],
            'post_status' => ['publish', 'draft'],
            'posts_per_page' => -1,
        ));
        foreach ($query->get_posts() as $p) {
            wp_delete_post($p->ID);
        }

        /* Delete meta data. */
        foreach ([
            PostRecentVisits::META_KEY,
            Metas::itemId()
        ] as $meta) {
            $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE meta_key = %s;", [$meta]));
        }

        /* Delete term_taxonomy. */
        $wpdb->get_results("DELETE FROM $wpdb->term_taxonomy WHERE taxonomy IN (" . join(',', array_map(function ($term) {
            return "'" . $term . "'";
        }, [
            Taxonomies::amenities(),
            Taxonomies::location()
        ])) . ")");

        /* Delete term relationships. */
        $wpdb->get_results("DELETE FROM $wpdb->term_relationships");

        /* Delete terms meta data. */
        $wpdb->get_results("DELETE FROM $wpdb->termmeta WHERE meta_key LIKE 'rezfusion_hub_%'");

        /* Delete posts meta data. */
        $wpdb->get_results("DELETE FROM $wpdb->postmeta WHERE meta_key LIKE 'rezfusion_hub_%'");
        $wpdb->get_results("DELETE FROM $wpdb->postmeta WHERE meta_key LIKE 'rzf_%'");

        /* Delete reviews. */
        $this->deleteReviews();

        /* Delete terms. */
        $wpdb->get_results("DELETE FROM $wpdb->terms");

        /* Delete options. */
        // $wpdb->get_results("DELETE FROM $wpdb->options WHERE option_name LIKE '%rezfusion%' AND option_name NOT IN (" .
        //     join(', ', array_map(function ($option) {
        //         return "'$option'";
        //     }, [
        //         'rezfusion_hub_repository_token',
        //         'rezfusion_hub_env',
        //         'rezfusion_hub_channel',
        //         'rezfusion_hub_folder',
        //         '_transient_rezfusion_hub_url_map'
        //     ])) . ")");
    }
}
