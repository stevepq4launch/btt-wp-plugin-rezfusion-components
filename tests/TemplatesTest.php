<?php

/**
 * @file Tests for Templates.
 */

namespace Rezfusion\Tests;

use Rezfusion\Template;

class TemplatesTest extends BaseTestCase
{
    /**
     * @var string
     */
    const TEMPLATE_NAME = 'test-template.php';

    private static function templateName()
    {
        return static::TEMPLATE_NAME;
    }

    private static function templateDir()
    {
        return ABSPATH . WPINC . '/theme-compat';
    }

    private static function templateFullPath()
    {
        return static::templateDir() . '/' . static::templateName();
    }

    private function createTestTemplate()
    {
        $this->deleteTestTemplate();
        if (!file_exists(static::templateDir())) {
            mkdir(static::templateDir(), 0777, true);
        }
        if (!file_exists(static::templateFullPath())) {
            file_put_contents(static::templateFullPath(), '<div><?php echo $testVar1; ?></div><br/><div><?php echo $testVar2; ?></div>');
        }
    }

    private function deleteTestTemplate()
    {
        if (file_exists(static::templateFullPath())) {
            unlink(static::templateFullPath());
        }
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->createTestTemplate();
    }

    public function testLocateTemplate()
    {
        $Template = new Template(static::templateName());
        $this->assertSame('<div>template-test-var-1-value</div><br/><div>template-test-var-2-value</div>', $Template->render([
            'testVar1' => 'template-test-var-1-value',
            'testVar2' => 'template-test-var-2-value'
        ]));
        $MultipleTemplate = new Template(static::templateName());
        $this->assertSame('<div></div><br/><div>template-test-var-2-value</div>', $MultipleTemplate->render([
            'testVar1' => '',
            'testVar2' => 'template-test-var-2-value'
        ], true));
    }

    public function tearDown(): void
    {
        $this->deleteTestTemplate();
    }
}
