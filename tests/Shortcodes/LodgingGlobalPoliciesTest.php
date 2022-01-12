<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Shortcodes\LodgingGlobalPolicies;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class LodgingGlobalPoliciesTest extends BaseTestCase
{

    private function renderShortcode($collapse = 0)
    {
        $Shortcode = new LodgingGlobalPolicies(new Template(Templates::itemPoliciesTemplate()));

        foreach ([
            Options::policiesGeneral() => 'General Policy.',
            Options::policiesPets() => 'Pets Policy.',
            Options::policiesPayment() => 'Payment Policy.',
            Options::policiesCancellation() => 'Cancellation Policy.',
            Options::policiesChanging() => 'Changing Policy.',
            Options::policiesInsurance() => 'Insurance Policy.',
            Options::policiesCleaning() => 'Cleaning Policy.'
        ] as $option => $value) {
            OptionManager::update($option, $value);
        }

        $html = $Shortcode->render(['collapse' => $collapse]);
        $Document = TestHelper::makeDOMDocument($html);
        $xpath = new \DOMXPath($Document);
        $classesToAssert = [
            'lodging-item-details__section-heading',
            'lodging-item-policies__list',
            'lodging-item-policies__section lodging-item-policies__section--general',
            'lodging-item-policies__section lodging-item-policies__section--pets',
            'lodging-item-policies__section lodging-item-policies__section--payment',
            'lodging-item-policies__section lodging-item-policies__section--cancellation',
            'lodging-item-policies__section lodging-item-policies__section--changing',
            'lodging-item-policies__section lodging-item-policies__section--insurance',
            'lodging-item-policies__section lodging-item-policies__section--cleaning'
        ];
        foreach ($classesToAssert as $class) {
            TestHelper::assertElementWithClassExists($this, $xpath, $class);
        }
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRender(): void
    {
        $this->renderShortcode(0);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithCollapse(): void
    {
        $this->renderShortcode(1);
    }
}
