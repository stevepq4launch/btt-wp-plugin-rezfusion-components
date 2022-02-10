<?php

namespace Rezfusion\Tests\Repository;

use Error;
use InvalidArgumentException;
use Rezfusion\Client\ClientInterface;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Repository\CategoryRepository;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\API_TestClientFactory;
use RuntimeException;

class CategoryRepositoryTest extends BaseTestCase
{
    /**
     * @var string
     */
    const AMENITIES_TAXONOMY = 'rzf_amenities';

    /**
     * @var string
     */
    const AMENITIES_CATEGORY_NAME = 'Amenities';

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();
        DeleteDataService::unlock();
    }

    private function makeCategoryRepository(): CategoryRepository
    {
        return new CategoryRepository(Plugin::apiClient());
    }

    private function makeCategoryRepositoryWithCategories($categories = []): CategoryRepository
    {
        $API_Client = $this->createMock(ClientInterface::class);
        $API_Client->method('getCategories')->willReturn($categories);
        return new CategoryRepository($API_Client);
    }

    private function makeCategories($data): object
    {
        return json_decode(json_encode([
            'data' =>  [
                'categoryInfo' =>  [
                    'categories' =>  $data
                ]
            ]
        ]));
    }

    private function makeCategoriesWithDuplicates(): object
    {
        return $this->makeCategories([
            [
                'name' => static::AMENITIES_CATEGORY_NAME,
                'values' =>  [
                    ['id' => 1000, 'name' => 'cat-1']
                ]
            ],
            [
                'name' => static::AMENITIES_CATEGORY_NAME,
                'values' =>  [
                    ['id' => 1000, 'name' => 'cat-1']
                ]
            ]
        ]);
    }

    public function testDeleteCategoryWithInvalidCategoryId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid category ID.');
        $CategoryRepository = $this->makeCategoryRepository();
        $CategoryRepository->deleteCategory(null);
    }

    public function testDeleteCategoryWithInvalidTaxonomy(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid taxonomy.');
        $CategoryRepository = $this->makeCategoryRepository();
        $CategoryRepository->deleteCategory(1000, '');
    }

    public function testUpdateCategoriesWithEmptyTerms(): void
    {
        (new DeleteDataService)->run();
        $CategoryRepository = $this->makeCategoryRepositoryWithCategories([]);
        $CategoryRepository->updateCategories(get_rezfusion_option(Options::hubChannelURL()));
        $currentCategories = $CategoryRepository->getCategories();
        $this->assertNull($currentCategories);
    }

    public function testUpdateCategoriesWithCategoryNameDuplicate(): void
    {
        (new DeleteDataService)->run();
        $CategoryRepository = $this->makeCategoryRepositoryWithCategories($this->makeCategoriesWithDuplicates());
        $CategoryRepository->updateCategories(get_rezfusion_option(Options::hubChannelURL()));
        $currentCategories = $CategoryRepository->getCategories();
        $this->assertCount(1, $currentCategories);
    }

    public function testUpdateCategoriesWithInvalidTaxonomy(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Invalid taxonomy.');
        $CategoryRepository = $this->makeCategoryRepositoryWithCategories($this->makeCategories(
            [
                [
                    'name' => 'invalid-taxonomy-1',
                    'values' =>  [
                        ['id' => 1000, 'name' => 'cat-1']
                    ]
                ]
            ]
        ));
        $CategoryRepository->updateCategories(get_rezfusion_option(Options::hubChannelURL()));
    }

    public function testUpdateCategoriesWithMissingCategoryID(): void
    {
        (new DeleteDataService)->run();
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid category (term) ID.');
        $API = (new API_TestClientFactory)->make();
        $CategoryRepository = $this->createPartialMock(CategoryRepository::class, ['findCategory']);
        $reflection = new \ReflectionClass(CategoryRepository::class);
        $reflection_property = $reflection->getProperty('client');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($CategoryRepository, $API);
        $CategoryRepository->method('findCategory')->willReturn([
            [
                'id' => 1
            ]
        ]);
        $CategoryRepository->updateCategories(
            get_rezfusion_option(Options::hubChannelURL())
        );
    }

    public function testUpdateCategoriesWithTaxonomyNotDefined(): void
    {
        (new DeleteDataService)->run();
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Taxonomy is not defined.');

        $API = (new API_TestClientFactory)->make();
        $CategoryRepository = $this->getMockBuilder(CategoryRepository::class)
            ->setConstructorArgs([$API])
            ->onlyMethods(['prepareCategoriesDataForUpdate'])
            ->getMock();

        $CategoryRepository->method('prepareCategoriesDataForUpdate')
            ->willReturn(
                [
                    'taxonomies' => [
                        'main-cat-1'
                    ],
                    'category_values' => [
                        1 => (object) [
                            'name' => ' ',
                            'id' => 1
                        ]
                    ]
                ]
            );

        $CategoryRepository->updateCategories(
            get_rezfusion_option(Options::hubChannelURL())
        );
    }

    public function testUpdateCategoriesWithInvalidCategorySlug(): void
    {
        (new DeleteDataService)->run();
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Category slug is not defined.');

        $API = (new API_TestClientFactory)->make();
        $CategoryRepository = $this->getMockBuilder(CategoryRepository::class)
            ->setConstructorArgs([$API])
            ->onlyMethods(['prepareCategoriesDataForUpdate'])
            ->getMock();

        $CategoryRepository->method('prepareCategoriesDataForUpdate')
            ->willReturn(
                [
                    'taxonomies' => [
                        'main-cat-1'
                    ],
                    'category_values' => [
                        1 => (object) [
                            'name' => ' ',
                            'wp_taxonomy_name' => 'main-cat-1',
                            'id' => 1
                        ]
                    ]
                ]
            );

        $CategoryRepository->updateCategories(
            get_rezfusion_option(Options::hubChannelURL())
        );
    }

    public function testUpdateCategoriesWithWpError(): void
    {
        (new DeleteDataService)->run();
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Generic error.');
        $API = (new API_TestClientFactory)->make();
        $CategoryRepository = $this->createPartialMock(CategoryRepository::class, ['saveCategory']);
        $reflection = new \ReflectionClass(CategoryRepository::class);
        $reflection_property = $reflection->getProperty('client');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($CategoryRepository, $API);
        $CategoryRepository->method('saveCategory')->willReturn(
            new \WP_Error(-1, 'Generic error.')
        );
        $CategoryRepository->updateCategories(
            get_rezfusion_option(Options::hubChannelURL())
        );
    }

    public function testDeleteCategory(): void
    {
        (new DeleteDataService)->run();
        $CategoryRepository = $this->makeCategoryRepositoryWithCategories($this->makeCategories([
            [
                'name' => static::AMENITIES_CATEGORY_NAME,
                'values' =>  [
                    ['id' => 1000, 'name' => 'cat-1']
                ]
            ],
        ]));
        $CategoryRepository->updateCategories(
            get_rezfusion_option(Options::hubChannelURL())
        );
        $categories = $CategoryRepository->getCategories();
        $this->assertCount(1, $categories);
        $categoryID = $categories[0]->term_id;
        $categoryTaxonomy = $categories[0]->taxonomy;
        $this->assertNotEmpty($categoryID);
        $this->assertIsNumeric($categoryID);
        $this->assertNotEmpty($categoryTaxonomy);
        $this->assertSame(static::AMENITIES_TAXONOMY, $categoryTaxonomy);
        $this->assertTrue($CategoryRepository->deleteCategory($categoryID, $categoryTaxonomy));
        $this->assertNull($CategoryRepository->getCategories());
    }

    public function testUpdateCategoriesWithCategoryNotFound(): void
    {
        (new DeleteDataService)->run();
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Category (term) not found.');
        $API = (new API_TestClientFactory)->make();
        $CategoryRepository = $this->createPartialMock(CategoryRepository::class, ['saveCategory']);
        $reflection = new \ReflectionClass(CategoryRepository::class);
        $reflection_property = $reflection->getProperty('client');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($CategoryRepository, $API);
        $CategoryRepository->method('saveCategory')->willReturn(null);
        $CategoryRepository->updateCategories(
            get_rezfusion_option(Options::hubChannelURL())
        );
    }

    public function testSaveCategoryWithInvalidParameters(): void
    {
        $this->refreshDatabaseDataAfterTest();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid parameter(s).');
        $CategoryRepository = $this->makeCategoryRepository();
        $CategoryRepository->saveCategory(null, null, null);
    }
}
