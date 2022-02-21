<?php

namespace Rezfusion\Service;

use Rezfusion\Client\ClientInterface;
use Rezfusion\Entity\HubDataPropertyAdapter;
use Rezfusion\Entity\PropertyInterface;
use Rezfusion\Metas;
use Rezfusion\PostStatus;
use Rezfusion\Repository\ItemRepository;

class ItemsUpdateService implements RunableInterface
{
    /**
     * @var ClientInterface
     */
    private $Client = null;

    /**
     * @var string
     */
    private $channel = '';

    /**
     * @var ItemRepository
     */
    private $ItemRepository = null;

    /**
     * @param ClientInterface $Client
     * @param string $channel
     * @param ItemRepository $ItemRepository
     */
    public function __construct(ClientInterface $Client, string $channel = '', ItemRepository $ItemRepository)
    {
        $this->Client = $Client;
        $this->channel = $channel;
        $this->ItemRepository = $ItemRepository;
    }

    /**
     * Process array of property items.
     * @param PropertyInterface[] $items
     * 
     * @return array
     */
    public function prepareLocalItems(array $items = []): array
    {
        // Rekey the array by ID.
        $outputItems = array_reduce($items, function ($carry, $Item) {
            /** @var PropertyInterface $Item */
            if (!empty($Item->getId())) {
                if (!empty($Item->getId())) {
                    if (!isset($carry[$Item->getId()])) {
                        $carry[$Item->getId()] = [];
                    }
                    $carry[$Item->getId()][] = $Item;
                }
            }
            return $carry;
        }, []);

        return is_array($outputItems) ? $outputItems : [];
    }

    /**
     * Perform tagging of local items during item update. This is not part
     * of the public repository API.
     *
     * @param $apiItem
     * @param $post
     */
    private function processItemCategories($apiItem, $post)
    {
        if (empty($apiItem->category_values)) {
            return;
        }

        $values = array_map(function ($value) {
            return $value->value->id;
        }, $apiItem->category_values);

        $args = [
            'hide_empty' => FALSE,
            'fields' => 'all',
            'count' => TRUE,
            'meta_query' => [
                [
                    'key' => Metas::categoryValueId(),
                    'value' => $values,
                    'compare' => 'IN',
                ],
            ],
        ];

        $taxonomies = [];
        $query = new \WP_Term_Query($args);
        if (!empty($query->terms)) {
            $taxonomies = array_reduce($query->terms, function ($carry, $item) {
                if (!isset($carry[$item->taxonomy])) {
                    $carry[$item->taxonomy] = [$item->term_id];
                } else {
                    $carry[$item->taxonomy][] = $item->term_id;
                }
                return $carry;
            }, []);
        }

        foreach ($taxonomies as $taxonomy => $term_ids) {
            wp_set_post_terms($post, $term_ids, $taxonomy);
        }
    }

    public function run()
    {
        $items = $this->Client->getItems($this->channel);
        $localItems = $this->prepareLocalItems($this->ItemRepository->findItems([
            PostStatus::publishStatus(),
            PostStatus::draftStatus(),
            PostStatus::trashStatus()
        ]));

        if (isset($items->data->lodgingProducts->results) && !empty($items->data->lodgingProducts->results)) {
            $PropertiesPermalinksMapRebuildService = new PropertiesPermalinksMapRebuildService($items->data->lodgingProducts->results, $this->ItemRepository);

            foreach ($items->data->lodgingProducts->results as $result) {
                $Property = new HubDataPropertyAdapter($result);
                $propertyId = $Property->getId();
                $Property->setPostStatus(PostStatus::publishStatus());

                if (!empty($localItems[$propertyId]) && !empty($localItems[$propertyId][0])) {
                    $Property->setPostId($localItems[$propertyId][0]->getPostId());
                    // Activate (publish) only the first item.
                    unset($localItems[$propertyId][0]);
                }
                $this->ItemRepository->saveItem($Property);
                // Add tags to items.
                $this->processItemCategories($result->item, $Property->getPostId());
            }

            // These don't exist in remote source, so unpublish them.
            if (!empty($localItems)) {
                foreach ($localItems as $items) {
                    foreach ($items as $Item) {
                        wp_update_post([
                            'ID' => $Item->getPostId(),
                            'post_status' => PostStatus::draftStatus()
                        ]);
                    }
                }
            }

            $PropertiesPermalinksMapRebuildService->run();
        }
    }
}
