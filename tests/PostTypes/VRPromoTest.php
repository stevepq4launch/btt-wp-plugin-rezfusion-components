<?php

namespace Rezfusion\Tests\PostTypes;

use Rezfusion\Actions;
use Rezfusion\Metas;
use Rezfusion\PostTypes;
use Rezfusion\PostTypes\VRPromo;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\TestHelper;
use Rezfusion\Tests\TestHelper\UserHelper;
use stdClass;

class VRPromoTest extends BaseTestCase
{
    /**
     * @var VRPromo
     */
    private $VR_Promo;

    public function setUp(): void
    {
        parent::setUp();
        $this->VR_Promo = new VRPromo(PostTypes::promo());
    }

    private function assertPromoMeta($meta, $expected, $count = 1)
    {
        $this->assertIsArray($meta);
        $this->assertCount($count, $meta);
        if (empty($expected)) {
            $this->assertEmpty($meta);
        } else {
            $this->assertContains($expected, $meta);
        }
    }

    private function includeRequiredFiles(): void
    {
        TestHelper::includeTemplateFunctions();
    }

    private function promoMetaSaveTest(callable $callback, $post, $POST_Key, $metaKey): void
    {
        $this->assertNotEmpty($post->ID);
        delete_post_meta($post->ID, $metaKey);

        // Test without user first.
        $callback();
        $this->assertTrue(true);

        // Create new meta; test as admin.
        UserHelper::logInAdminUser();
        $value = 'test-1';
        $_POST[$POST_Key] = $value;
        $callback();
        $this->assertPromoMeta(
            get_post_meta($post->ID, $metaKey),
            $value
        );

        // Update meta.
        $value = 'test-2';
        $_POST[$POST_Key] = $value;
        $callback();
        $this->assertPromoMeta(
            get_post_meta($post->ID, $metaKey),
            $value
        );

        // Erase meta.
        $value = '';
        $_POST[$POST_Key] = $value;
        $callback();
        $this->assertPromoMeta(
            get_post_meta($post->ID, $metaKey),
            $value,
            0
        );
    }

    private function assertHTML_ContainsPromoCodeInput(string $html = ''): void
    {
        $this->assertStringContainsString('<p><input type="text" name="promo-code-input" id="promo-code-input" value=""></p>', $html);
    }

    private function assertHTML_ContainsListingMetaBoxes(string $html = ''): void
    {
        $contains = [
            'function rzfCheckToggle\(\)',
            '\<input type="checkbox" name="promo-listing-checkbox\[\]" id="rzf-listing-.*" value=".*"  style="margin\: 0 0\.25rem 0 0;"\>',
            '\<a id="rzf-promo-listing-select-all" class="button button-primary button-large" onclick="rzfCheckToggle\(\)"\>Select All\<\/a\>'
        ];
        $this->assertNotEmpty($html);
        foreach ($contains as $string) {
            $this->assertRegExp('/' . $string . '/i', $html);
        }
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRzfAddPromoListingMeta()
    {
        $this->includeRequiredFiles();
        remove_all_actions(Actions::addMetaBoxes());
        $this->VR_Promo->rzf_add_promo_listing_meta();
        do_action(Actions::addMetaBoxes());
        do_meta_boxes($this->VR_Promo->getPostTypeName(), 'normal', new stdClass());
        $this->setOutputCallback(function ($html) {
            $this->assertHTML_ContainsListingMetaBoxes($html);
        });
    }

    public function testRzfPromoListingMetaBox()
    {
        $this->setOutputCallback(function ($html) {
            $this->assertHTML_ContainsListingMetaBoxes($html);
        });
        $post = PostHelper::getRecentPost();
        $this->VR_Promo->rzf_promo_listing_meta_box($post);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRzfSavePromoListingMeta()
    {
        $post = PostHelper::getRecentPost();
        $this->promoMetaSaveTest(
            function () use ($post) {
                $this->VR_Promo->rzf_save_promo_listing_meta($post->ID, $post);
            },
            $post,
            'promo-listing-checkbox',
            Metas::promoListingValue()
        );
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRzfAddPromoCodeMeta()
    {
        $this->includeRequiredFiles();
        remove_all_actions(Actions::addMetaBoxes());
        $this->VR_Promo->rzf_add_promo_code_meta();
        do_action(Actions::addMetaBoxes());
        do_meta_boxes($this->VR_Promo->getPostTypeName(), 'normal', new stdClass());
        $this->setOutputCallback(function ($html) {
            $this->assertHTML_ContainsPromoCodeInput($html);
        });
    }

    public function testRzfPromoCodeMetaBox()
    {
        $post = PostHelper::getRecentPost();
        $this->setOutputCallback(function ($html) {
            $this->assertHTML_ContainsPromoCodeInput($html);
        });
        $this->VR_Promo->rzf_promo_code_meta_box($post);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRzfSavePromoCodeMeta()
    {
        $post = PostHelper::getRecentPost();
        $this->promoMetaSaveTest(
            function () use ($post) {
                $this->VR_Promo->rzf_save_promo_code_meta($post->ID, $post);
            },
            $post,
            'promo-code-input',
            Metas::promoCodeValue()
        );
    }

    public function testAddMetaFields()
    {
        $this->assertEmpty($this->VR_Promo->addMetaFields());
    }

    public function testCreateListingField()
    {
        $this->assertEmpty($this->VR_Promo->createListingField());
    }
}
