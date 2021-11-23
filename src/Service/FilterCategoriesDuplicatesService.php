<?php

namespace Rezfusion\Service;

class FilterCategoriesDuplicatesService
{

    const IDS_TO_BE_REMOVED = [3681, 4029];

    /**
     * Fix array with categories.
     * 
     * (i) There are duplicates which makes tests invalid - "Washer / Dryer"
     * (i) and "Washer/Dryer", both gets the same slug "washer-dryer",
     * (i) so, for example, term_exists method returns true for either cases
     * (i) and in result only one category is saved.
     * 
     * @todo This should be removed after duplicates issue is handled.
     * 
     * @param mixed $categories
     * 
     * @return mixed
     */
    public function run($categories)
    {
        foreach ($categories->data->categoryInfo->categories as $category) {
            foreach ($category->values as $index => $categoryItem) {
                if (in_array($categoryItem->id, static::IDS_TO_BE_REMOVED))
                    unset($category->values[$index]);
            }
        }
        return $categories;
    }
}
