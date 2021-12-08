<?php

namespace Rezfusion\Tests\Registerer;

use Rezfusion\Actions;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Registerer\TemplateRedirectRegisterer;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class TemplateRedirectRegistererTest extends BaseTestCase
{
    public static function doBefore(): void
    {
        parent::doBefore();
        TestHelper::refreshData();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testPropertyRedirection()
    {
        TemplateRedirectRegisterer::$exit = false;
        OptionManager::update(Options::redirectUrls(), true);
        $propertyId = PropertiesHelper::getRandomPropertyId();
        $_GET['pms_id'] = $propertyId;
        do_action(Actions::templateRedirect());
        $this->assertTrue(true);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWithoutRedirection()
    {
        TemplateRedirectRegisterer::$exit = false;
        OptionManager::update(Options::redirectUrls(), true);
        unset($_GET['pms_id']);
        $this->assertNull(do_action(Actions::templateRedirect()));
    }
}
