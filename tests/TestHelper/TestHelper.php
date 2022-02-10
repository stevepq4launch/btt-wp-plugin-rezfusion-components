<?php

namespace Rezfusion\Tests\TestHelper;

use DOMDocument;
use DOMXPath;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Rezfusion\Actions;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Service\DataRefreshService;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Service\PropertiesPermalinksMapRebuildService;
use Rezfusion\Tests\Client\API_TestClient;
use RuntimeException;
use Twig\Error\RuntimeError;

class TestHelper
{
    public static function log($content, $encodeJSON = true): void
    {
        if ($encodeJSON === true) {
            $content = json_encode($content);
        }
        error_log($content);
    }

    public static function getBufferOutput(callable $function): string
    {
        ob_clean();
        $function();
        return ob_get_contents();
    }

    public static function makeAPI_TestClient(): API_TestClient
    {
        return Factory::makeAPI_TestClient();
    }

    public static function refreshData(): void
    {
        $DeleteDataServiceClassName = DeleteDataService::class;
        $DeleteDataServiceClassName::unlock();
        (new $DeleteDataServiceClassName)->run();
        $DeleteDataServiceClassName::lock();
        (new DataRefreshService(static::makeAPI_TestClient()))->run();
    }

    public static function callClassMethod($class, $method = '', array $arguments = [])
    {
        $ReflectionClass = new \ReflectionClass($class);
        $method = $ReflectionClass->getMethod($method);
        $method->setAccessible(true);
        return $method->invokeArgs($class, $arguments);
    }

    public static function assertStrings(TestCase $Test, $text = '', array $strings = []): void
    {
        $Test->assertNotEmpty($text);
        foreach ($strings as $string) {
            $Test->assertStringContainsStringIgnoringCase($string, $text);
        }
    }

    public static function assertRegExps(TestCase $Test, $text = '', array $strings = []): void
    {
        $Test->assertNotEmpty($text);
        foreach ($strings as $string) {
            $Test->assertRegExp($string, $text);
        }
    }

    public static function includeTemplateFunctions(): void
    {
        require_once(REZFUSION_PLUGIN_PATH . '/../../../wp-admin/includes/template.php');
        require_once(REZFUSION_PLUGIN_PATH . '/../../../wp-admin/includes/plugin.php');
        require_once(REZFUSION_PLUGIN_PATH . '/../../../wp-admin/includes/class-wp-screen.php');
        require_once(REZFUSION_PLUGIN_PATH . '/../../../wp-admin/includes/post.php');
        require_once(REZFUSION_PLUGIN_PATH . '/../../../wp-admin/includes/screen.php');
        do_action(Actions::init());
        do_action(Actions::adminInit());
    }

    public static function queryDOMXPath(DOMXPath $DOMXPath, $class)
    {
        return $DOMXPath->query('//*[@class="' . $class . '"]');
    }

    public static function assertElementWithClassExists(TestCase $Test, DOMXPath $DOMXPath, $class): void
    {
        $Test->assertGreaterThan(0, static::queryDOMXPath($DOMXPath, $class)->length, "(?) $class");
    }

    public static function assertElementContainingClassExists(TestCase $Test, DOMXPath $DOMXPath, $class): void
    {
        $Test->assertGreaterThan(0, $DOMXPath->query('//*[contains(@class, "' . $class . '")]')->length, "(?) $class");
    }

    public static function assertClassesCount(TestCase $Test, DOMXPath $DOMXPath, $class, $count = 0)
    {
        $Test->assertSame($count, static::queryDOMXPath($DOMXPath, $class)->length, "(?) $class");
    }


    public static function makeDOMDocument($html = ''): DOMDocument
    {
        $Document = new DOMDocument();
        libxml_use_internal_errors(true);
        $Document->loadHTML($html);
        libxml_use_internal_errors(false);
        return $Document;
    }

    public static function makeDOMXPath($html = ''): DOMXPath
    {
        return new DOMXPath(static::makeDOMDocument($html));
    }

    public static function rebuildPermalinks(): void
    {
        $properties = static::makeAPI_TestClient()->getItems(null);
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $Service = new PropertiesPermalinksMapRebuildService($properties, $ItemRepository);
        $Service->run();
    }
}
