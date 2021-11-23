<?php

namespace Rezfusion;

class Partial extends Template
{
    /**
     * @inheritdoc
     */
    public function render($variables = [], $multiple = false): string
    {
        $variables = apply_filters(Filters::variables($this->locateTemplate()), $variables);
        extract($variables);
        ob_start();
        require($this->locateTemplate());
        return ob_get_clean();
    }
}
