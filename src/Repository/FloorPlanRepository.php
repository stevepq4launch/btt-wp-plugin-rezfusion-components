<?php

namespace Rezfusion\Repository;

use InvalidArgumentException;
use Rezfusion\Metas;
use Rezfusion\PostTypes;
use RuntimeException;

/**
 * @file Repository provides a way to retrieve and save floor plan data.
 */
class FloorPlanRepository extends AbstractHubRepository
{
    /**
     * Filter key name for post ID.
     * @return string
     */
    public static function postID_FilterKey(): string
    {
        return 'postID';
    }

    /**
     * Creates query, applies filters to it, executes and returns result.
     * @param array $params
     * @throws RuntimeException
     * 
     * @return array|null
     */
    private function doQuery(array $params = [])
    {
        global $wpdb;
        $sql = "SELECT p.id as postID, p.post_title AS propertyName, pm.meta_value AS url FROM {$wpdb->posts} p LEFT JOIN {$wpdb->postmeta} pm ON pm.post_id = p.id AND pm.meta_key = %s WHERE p.post_type = %s AND p.post_status = %s";
        $queryParams = [
            Metas::postFloorPlanURL(),
            PostTypes::listing(),
            'publish'
        ];
        if (array_key_exists(static::postID_FilterKey(), $params)) {
            $sql .= " AND p.id = %d";
            $queryParams[] = $params[static::postID_FilterKey()];
        }
        $sql .= " ORDER BY propertyName";
        $result = $wpdb->get_results($wpdb->prepare($sql, $queryParams), ARRAY_A);
        if (is_wp_error($result)) {
            throw new RuntimeException(sprintf('Error occurred in %s method.', __METHOD__));
        }
        return $result;
    }

    /**
     * Find one floor plan data by post ID.
     * @param int $postID
     * 
     * @return array|null
     */
    public function findOneByPostID($postID = 0)
    {
        $result = $this->doQuery([static::postID_FilterKey() => $postID]);
        return ($result && is_array($result) && count($result) == 1) ? $result[0] : null;
    }

    /**
     * Find all floor plan(s) data.
     * 
     * @return array
     */
    public function findAll()
    {
        return $this->doQuery([]);
    }

    /**
     * Saves single floor plan data.
     * @param array $item
     * 
     * @return bool
     */
    public function save(array $item = []): bool
    {
        $postID = $item['postID'];
        $url = $item['url'];
        if (empty($postID)) {
            throw new InvalidArgumentException('Invalid post ID.');
        }
        $metaKey = Metas::postFloorPlanURL();
        if (!empty($url)) {
            return update_post_meta($postID, $metaKey, $url);
        } else {
            return delete_post_meta($postID, $metaKey);
        }
    }

    /**
     * Checks if property and/or post have floor plan URL defined.
     * @param string $propertyKey
     * @param int $postID
     * 
     * @return bool
     */
    public function hasFloorPlan($propertyKey = '', $postID = 0): bool
    {
        if (!empty($postID) && is_array($floorPlan = $this->findOneByPostID($postID)) && !empty($floorPlan['url'])) {
            return true;
        }
        if (!empty($propertyKey) && !empty($this->findURL_ForProperty($propertyKey))) {
            return true;
        }
        return false;
    }

    /**
     * Find URL for property.
     * @param string $propertyKey
     * 
     * @return string
     */
    public function findURL_ForProperty($propertyKey = ''): string
    {
        if (empty($propertyKey))
            return '';
        $result = $this->client->call(
            $this->client->getQuery(
                REZFUSION_PLUGIN_QUERIES_PATH . '/itemTour.graphql'
            ),
            [
                'channels' => [
                    'url' => $this->channel,
                ],
                'itemIds' => [$propertyKey]
            ]
        );
        if (
            !empty($result)
            && is_object($result)
            && @isset($result->data->lodgingProducts->results[0]->item->tour->url)
        ) {
            return $result->data->lodgingProducts->results[0]->item->tour->url;
        }
        return '';
    }
}
