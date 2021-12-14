<?php

namespace Rezfusion\Service;

use RuntimeException;

/**
 * Class handles slugs for data-set of categories.
 * It creates unique slugs for each category,
 * so duplicates can be properly handled.
 */
class CategoriesSlugsFixService
{
    /**
     * @param array $categories
     * 
     * @return array
     */
    public function fix(array $categories = []): array
    {
        $slugs = [];
        foreach ($categories as $category) {
            $slug = $this->slug($category, $slugs);
            $slugs[] = $slug;
            $category->slug = $slug;
        }
        return $categories;
    }

    /**
     * Create unique slug for category.
     * @param object $category
     * @param array $reservedSlugs
     * 
     * @return string
     */
    private function slug(object $category, array $reservedSlugs = [])
    {
        if (empty(@$category->name))
            throw new RuntimeException("Category doesn't have name key.");
        $slug = sanitize_title($category->name);
        $counter = 1;
        while (in_array($slug, $reservedSlugs)) {
            $counter++;
            $slug = sanitize_title($category->name) . '-' . $counter;
        }
        return $slug;
    }
}
