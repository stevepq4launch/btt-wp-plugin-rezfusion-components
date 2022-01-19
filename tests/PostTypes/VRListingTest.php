<?php

namespace Rezfusion\Tests\PostTypes;

use Rezfusion\PostTypes;
use Rezfusion\PostTypes\VRListing;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class VRListingTest extends BaseTestCase
{
    const ICON_TERM_ID = 1001;

    /**
     * @var VR_Listing
     */
    private $VR_Listing;

    private function iconTermID(): int
    {
        return static::ICON_TERM_ID;
    }

    private function saveIconMeta($termID, $value): void
    {
        $_POST['term-icon-picker'] = $value;
        $this->VR_Listing->saveIconPicker($termID, null);
    }

    private function assertIconMeta($termID, $expected): void
    {
        $iconKey = 'icon';
        $meta = get_term_meta($termID);
        $this->assertNotEmpty($meta);
        $this->assertArrayHasKey($iconKey, $meta);
        $this->assertContains($expected, $meta[$iconKey]);
        $this->assertSame($expected, $meta[$iconKey][0]);
    }

    private function deleteIconMeta($termID): void
    {
        delete_term_meta($termID, 'icon');
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->deleteIconMeta($this->iconTermID());
        $this->VR_Listing = new VRListing(PostTypes::listing());
    }

    public function testVRListingGetColumns()
    {
        $VR_Listing = new VRListing(PostTypes::listing());
        $expectedColumns = [
            "cb" => '<input type="checkbox" />',
            "title" => "Title",
            "beds" => "Beds",
            "baths" => "Baths",
            "taxonomy-test" => "test-value",
            "item_id" => "Item ID",
            "floor_plan_url" => "Custom Floor Plan URL",
            "date" => "Date"
        ];
        $columns = $VR_Listing->getColumns(['taxonomy-test' => 'test-value']);

        $this->assertIsArray($columns);
        $this->assertArrayHasKey('cb', $columns);
        $this->assertArrayHasKey('title', $columns);
        $this->assertArrayHasKey('beds', $columns);
        $this->assertArrayHasKey('baths', $columns);
        $this->assertArrayHasKey('taxonomy-test', $columns);
        $this->assertArrayHasKey('item_id', $columns);
        $this->assertArrayHasKey('date', $columns);
        $this->assertSame($expectedColumns, $columns);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testVRListingGetColumnContents()
    {
        TestHelper::refreshData();
        $VR_Listing = new VRListing(PostTypes::listing());
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $postId = PostHelper::getRecentPostId();
        $expectedPropertyID = $ItemRepository->getPropertyKeyByPostId($postId);
        $this->assertNotEmpty($expectedPropertyID);
        ob_clean();
        $VR_Listing->getColumnContents('beds', $postId);
        $beds = ob_get_clean();
        ob_start();
        $VR_Listing->getColumnContents('baths', $postId);
        $baths = ob_get_clean();
        ob_start();
        $VR_Listing->getColumnContents('item_id', $postId);
        $propertyId = ob_get_clean();
        ob_start();
        $this->assertIsNumeric($beds);
        $this->assertIsNumeric($baths);
        $this->assertSame($expectedPropertyID, $propertyId);
    }

    public function testAddIconPicker()
    {
        $this->setOutputCallback(function () {
        });
        ob_clean();
        $this->VR_Listing->addIconPicker('taxonomy-test');
        $content = ob_get_contents();
        $expectedStrings = [
            '<div class="form-field term-icon-picker">',
            '<label for="term-icon">Icon</label>',
            '<select name="term-icon-picker" id="term-icon" class="postform" style="font-family: \'FontAwesome\', system-ui, sans-serif">',
            '<option value="-1">none</option>',
            '<option value="fas fa-american-sign-language-interpreting">american-sign-language-interpreting &#xf2a3;</option>',
            '<p class="description">Select an icon to display if this category is set to featured</p>'
        ];
        foreach ($expectedStrings as $expect) {
            $this->assertTrue(
                strpos($content, $expect) === false ? false : true
            );
        }
    }

    public function testSaveIconPicker()
    {
        $expected = 'test-icon';
        $termID = $this->iconTermID();
        $this->saveIconMeta($termID, $expected);
        $this->assertIconMeta($termID, $expected);
        $this->deleteIconMeta($termID);
    }

    public function testEditIconPicker()
    {
        $termID = $this->iconTermID();
        $contains = [
            '<tr class="form-field term-icon-picker-wrap">',
            '<label for="term-icon">Icon</label>',
            '<select name="term-icon-picker" id="term-icon" class="postform" style="font-family: \'FontAwesome\', system-ui, sans-serif">',
            '<option value="fas fa-bell" >bell &#xf0f3;</option>',
            '<p class="description">Select an icon to display if this category is set to featured</p>'
        ];
        $this->setOutputCallback(function ($html) use ($contains) {
            $this->assertNotEmpty($html);
            foreach ($contains as $string) {
                $this->assertStringContainsString($string, $html);
            }
        });

        $this->saveIconMeta($termID, 'fas fa-arrow-up');
        $this->VR_Listing->editIconPicker($termID, null);
        delete_term_meta($termID, 'icon');
    }

    public function testUpdateIconPicker()
    {
        $termID = $this->iconTermID();
        $icon = 'fas fa-arrow-up';
        $expected = 'fab fa-uikit';

        $this->saveIconMeta($termID, $icon);
        $this->assertIconMeta($termID, $icon);
        $_POST['term-icon-picker'] = $expected;
        $this->VR_Listing->updateIconPicker($termID, '');
        $this->assertIconMeta($termID, $expected);
    }

    public function testFloorPlanURL_PostParameter(): void
    {
        $this->assertSame('floor-plan-url', VRListing::floorPlanURL_PostParameter());
    }

    public function testFloorPlanColumnName(): void
    {
        $this->assertSame('floor_plan_url', VRListing::floorPlanColumnName());
    }
}
