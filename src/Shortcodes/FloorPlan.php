<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Factory\FloorPlanRepositoryFactory;
use Rezfusion\Helper\FloorPlanHelper;
use Rezfusion\Plugin;

class FloorPlan extends Shortcode
{
    /**
     * @var string
     */
    protected $shortcode = 'rezfusion-floor-plan';

    public function render($atts = []): string
    {
        $FloorPlanHelper = new FloorPlanHelper(
            Plugin::getInstance()->getAssetsRegisterer(),
            (new FloorPlanRepositoryFactory)->make()
        );
        $atts = shortcode_atts([
            'propertyid' => '',
            'postid' => get_the_ID(),
            'elementselector' => ''
        ], $atts);
        $attributes = $FloorPlanHelper->prepareShortcodeAttributes(
            $atts['propertyid'],
            $atts['postid'],
            $atts['elementselector']
        );
        return $this->template->render($attributes);
    }
}
