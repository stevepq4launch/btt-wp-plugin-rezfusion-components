<?php

namespace Rezfusion\Service;

use Rezfusion\Metas;
use Rezfusion\Repository\CategoryRepository;

class RemoveRedundantCategoriesService
{

    /**
     * Get array of source keys.
     * @param mixed $categories
     * 
     * @return array
     */
    private function getKeysFromSourceCategories($categories): array
    {
        $keys = [];
        foreach ($categories->data->categoryInfo->categories as $sourceCategory) {
            foreach ($sourceCategory->values as $item) {
                if (empty($id = $item->id))
                    continue;
                if (!in_array($id, $keys))
                    $keys[] = $id;
            }
        }
        return $keys;
    }

    /**
     * Get categories to be removed by comparing existing data
     * and keys from the source.
     * @param mixed $categoriesInDatabase
     * @param mixed $validKeys
     * 
     * @return array
     */
    private function getCategoriesToBeRemoved($categoriesInDatabase, $keysFromSource): array
    {
        $toRemove = [];
        foreach ($categoriesInDatabase as $category) {
            $categoryId = @get_term_meta($category->term_id, Metas::categoryValueId())[0];
            if (!empty($categoryId) && !in_array($categoryId, $keysFromSource))
                $toRemove[] = [$category->term_id, $category->taxonomy];
        }
        return $toRemove;
    }

    public function run(
        CategoryRepository $CategoryRepository,
        $currentCategories,
        $sourceCategories
    ) {
        if ($currentCategories && $sourceCategories) {
            foreach ($this->getCategoriesToBeRemoved(
                $currentCategories,
                $this->getKeysFromSourceCategories($sourceCategories)
            ) as $categoryToRemove) {
                $CategoryRepository->deleteCategory(...$categoryToRemove);
            }
        }
    }
}
