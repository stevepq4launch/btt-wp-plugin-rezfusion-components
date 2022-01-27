<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Shortcodes\QuickSearch;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;

class QuickSearchTest extends BaseTestCase
{
    private function makeExpectedHTML($additionalClassName = ''): string
    {
        if (!empty($additionalClassName)) {
            $additionalClassName = ' ' . $additionalClassName;
        }
        return '<div id="rezfusion-quicksearch" class="quick-search' . $additionalClassName . '"></div>';
    }

    private function doRenderTest(array $attributes = [], $expect = ''): void
    {
        $Shortcode = new QuickSearch(new Template(Templates::quickSearchTemplate()));
        $html = $Shortcode->render($attributes);
        $this->assertSame($expect, $html);
    }

    public function testRender(): void
    {
        $this->doRenderTest([], $this->makeExpectedHTML(''));
    }

    public function testRenderWithContainerClass(): void
    {
        $testClassName = 'shortcode-test-class';
        $this->doRenderTest([
            'container-class' => $testClassName
        ], $this->makeExpectedHTML($testClassName));
    }
}
