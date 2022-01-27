<?php

/**
 * @file Tests for TemplateFunctions.
 */

namespace Rezfusion\Tests;

use Rezfusion\Templates;

class TemplateFunctionsTest extends BaseTestCase
{
    public function testRezfusionModalOpen()
    {
        $content = rezfusion_modal_open('test-modal');
        $expected = <<<HTML
<div class="rezfusion-modal" id="test-modal">
    <div class="rezfusion-modal__wrap">
        <span class="rezfusion-modal__close">&times;</span>
        <div class="rezfusion-modal__content">
HTML;
        $this->assertSame($expected, $content);
    }

    public function testRezfusionModalClose()
    {
        $content = rezfusion_modal_close();
        $expected = <<<HTML
        </div>
    </div>
</div>
HTML;
        $this->assertSame($expected, $content);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRezfusionLoadTemplate()
    {
        $this->setOutputCallback(function () {
        });
        rezfusion_load_template(Templates::favoritesTemplate());
        $content = ob_get_contents();
        $this->assertSame('<div id="favorites-page"></div>', $content);
    }
}
