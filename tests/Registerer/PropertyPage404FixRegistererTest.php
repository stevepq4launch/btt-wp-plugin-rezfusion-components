<?php

namespace Rezfusion\Tests\Registerer;

use Rezfusion\Actions;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Registerer\PropertyPage404FixRegisterer;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\API_TestClientFactory;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class PropertyPage404FixRegistererTest extends BaseTestCase
{
    const PROPERTY_ID_URL_PARAMETER = 'pms_id';

    public static function doBefore(): void
    {
        parent::doBefore();
        TestHelper::refreshData();
        delete_transient(Options::URL_Map());
    }

    private function makeRegisterer(): PropertyPage404FixRegisterer
    {
        return new PropertyPage404FixRegisterer(new API_TestClientFactory());
    }

    private function prepareRegisterer(): PropertyPage404FixRegisterer
    {
        $Registerer = $this->makeRegisterer();
        remove_all_actions(Actions::templateRedirect());
        $Registerer->register();
        return $Registerer;
    }

    private function runRegisterer(): void
    {
        $this->prepareRegisterer();
        do_action(Actions::templateRedirect());
    }

    private function getRedirectUrl($url)
    {
        stream_context_set_default(array(
            'http' => array(
                'method' => 'HEAD'
            )
        ));
        $headers = get_headers($url, 1);
        if ($headers !== false && isset($headers['Location'])) {
            return $headers['Location'];
        }
        return false;
    }

    private function assertFinalURL($expectedURL = '', &$finalURL = ''): void
    {
        $this->assertNotEmpty($expectedURL);
        $this->assertStringContainsString('http://localhost', $expectedURL);
        add_filter('wp_redirect', function ($URL) use (&$finalURL) {
            $finalURL = $URL;
        });
    }

    private function prepare404(): void
    {
        global $wp_query;
        $WP_Query = $this->createPartialMock(\WP_Query::class, ['is_404']);
        $WP_Query->method('is_404')->willReturn(true);
        $wp_query = $WP_Query;
    }

    private function prepareURL($propertyID = false, $parameters = ''): void
    {
        $url = '/';
        $queryString = '';
        if ($propertyID !== false) {
            $slug = Plugin::getInstance()->getOption(Options::customListingSlug());
            $url .= "{$slug}";
            $queryString .= static::PROPERTY_ID_URL_PARAMETER . "={$propertyID}";
            $_GET['pms_id'] = $propertyID;
        }
        if (!empty($parameters)) {
            $queryString .= $parameters;
        }
        if (!empty($queryString)) {
            $_SERVER['QUERY_STRING'] = $queryString;
            $url .= "?{$queryString}";
        }
        $_SERVER['REQUEST_URI'] = $url;
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWithout404(): void
    {
        $this->runRegisterer();
        $this->assertTrue(true);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWithoutValidURL(): void
    {
        $this->prepare404();
        $this->prepareURL(false);
        $this->runRegisterer();
        $this->assertTrue(true);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWithoutPropertyID(): void
    {
        $this->prepare404();
        $this->prepareURL('');
        $this->runRegisterer();
        $this->assertTrue(true);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWithValidProperty(): void
    {
        delete_transient(Options::URL_Map());
        $propertyID = PropertiesHelper::getRandomPropertyId();
        $this->prepare404();
        $this->prepareURL($propertyID);
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $post = $ItemRepository->getItemById($propertyID);
        $this->assertCount(1, $post);
        $postID = @$post[0]['post_id'];
        $this->assertNotEmpty($postID);
        $this->assertIsNumeric($postID);
        $permalink = get_permalink($postID);
        $this->assertNotEmpty($permalink);
        $expectedURL = $permalink . '?' . static::PROPERTY_ID_URL_PARAMETER . "=${propertyID}";
        $finalURL = '';
        $this->assertFinalURL($expectedURL, $finalURL);
        $this->runRegisterer();
        $this->assertSame($expectedURL, $finalURL);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWithURL_Parameters(): void
    {
        delete_transient(Options::URL_Map());
        $propertyID = PropertiesHelper::getRandomPropertyId();
        $parameters = '&test1=value1&test2=value2';
        $this->prepare404();
        $this->prepareURL($propertyID, $parameters);
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $post = $ItemRepository->getItemById($propertyID);
        $this->assertCount(1, $post);
        $postID = @$post[0]['post_id'];
        $this->assertNotEmpty($postID);
        $this->assertIsNumeric($postID);
        $permalink = get_permalink($postID);
        $this->assertNotEmpty($permalink);
        $expectedURL = $permalink . '?' . static::PROPERTY_ID_URL_PARAMETER . "={$propertyID}" . $parameters;
        $finalURL = '';
        $this->assertFinalURL($permalink, $finalURL);
        $this->runRegisterer();
        $this->assertSame($expectedURL, $finalURL);
    }
}
