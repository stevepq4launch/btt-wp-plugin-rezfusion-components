<?php

namespace Rezfusion\Factory;

use Rezfusion\Plugin;
use Rezfusion\Repository\ItemRepository;

class FeaturedPropertiesConfigurationTemplateVariablesFactory
{
    /**
     * @return array
     */
    public function make()
    {
        $propertiesDataSource = (new ItemRepository(Plugin::apiClient()))->getAllItems();
        foreach ($propertiesDataSource as &$item) {
            $item['meta_id'] = intval($item['meta_id']);
        }
        return [
            'propertiesDataSource' => $propertiesDataSource
        ];
    }
}
