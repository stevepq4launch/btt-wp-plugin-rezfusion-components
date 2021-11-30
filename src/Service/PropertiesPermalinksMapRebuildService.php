<?php

namespace Rezfusion\Service;

use Rezfusion\Options;
use Rezfusion\Repository\ItemRepository;
use RuntimeException;

class PropertiesPermalinksMapRebuildService implements RunableInterface
{
    /**
     * @var array
     */
    private $properties = [];

    /**
     * @var ItemRepository
     */
    private $ItemRepository;

    /**
     * @param mixed $properties
     * @param ItemRepository $ItemRepository
     */
    public function __construct($properties, ItemRepository $ItemRepository)
    {
        $this->properties = $properties;
        $this->ItemRepository = $ItemRepository;
    }

    public function run(): void
    {
        if (isset($this->properties) && !empty($this->properties) && is_array($this->properties)) {
            $urlsMap = [];

            foreach ($this->properties as $property) {

                if (empty($propertyID = $property->item->id))
                    throw new RuntimeException('Invalid property ID.');

                $post = null;
                $posts = $this->ItemRepository->getItemById($propertyID);

                if (is_array($posts) && count($posts) === 1)
                    $post = $posts[0];

                if (!$post)
                    throw new RuntimeException('Post for property not found.');

                if (!isset($post['post_id']) || empty($post['post_id']))
                    throw new RuntimeException('Invalid property post ID.');

                if (isset($urlsMap[$propertyID]))
                    throw new RuntimeException('Property URL duplicate.');

                $urlsMap[$propertyID] = get_permalink($post['post_id']);
            }

            set_transient(Options::URL_Map(), $urlsMap);
        }
    }
}
