<?php

namespace Rezfusion;

class Partial extends Template
{
    /**
     * @inheritdoc
     */
    public function render($variables = []): string
    {
        $variables = apply_filters("variables_{$this->locateTemplate()}", $variables);
        extract($variables);
        ob_start();
        require($this->locateTemplate());
        return ob_get_clean();
    }
}
