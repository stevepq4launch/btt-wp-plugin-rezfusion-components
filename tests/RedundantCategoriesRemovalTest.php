<?php

namespace Rezfusion\Tests;

use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Repository\CategoryRepository;
use Rezfusion\Service\RemoveRedundantCategoriesService;
use Rezfusion\Tests\TestHelper\TestHelper;

class RedundantCategoriesRemovalTest extends BaseTestCase
{

    private function reduceCategories($categories)
    {
        foreach ($categories
            ->data
            ->categoryInfo
            ->categories as $cat) {
            if (count($cat->values) > 3) {
                array_splice($cat->values, 0, 3);
                break;
            }
        }
        return $categories;
    }

    private function countCategoriesItems($categories): int
    {
        return array_reduce($categories
            ->data
            ->categoryInfo
            ->categories, function ($carry, $category) {
            if ($count = count($category->values))
                $carry += $count;
            return $carry;
        }, 0);
    }

    public function testRedundantDataRemoval()
    {
        $this->refreshDatabaseDataAfterTest();
        $API_Client = TestHelper::makeAPI_TestClient();
        $CategoriesRepository = new CategoryRepository($API_Client);
        $categoriesFromSource = $API_Client->getCategories(Plugin::getInstance()->getOption(Options::hubChannelURL()));
        $localCategories = $CategoriesRepository->getCategories();
        $initialCategoriesCount = count($localCategories);
        $this->assertGreaterThan(2, $initialCategoriesCount);
        $this->assertSame($this->countCategoriesItems($categoriesFromSource), $initialCategoriesCount);
        (new RemoveRedundantCategoriesService)->run(
            $CategoriesRepository,
            $localCategories,
            $this->reduceCategories($categoriesFromSource)
        );
        $this->assertSame($initialCategoriesCount - 3, count($CategoriesRepository->getCategories()));
    }
}
