<?php

namespace Rezfusion\Registerer;

class FunctionsRegisterer implements RegistererInterface
{

    /**
     * @var string
     */
    const TEMPLATE_FUNCTIONS_FILEPATH = REZFUSION_PLUGIN_PATH . 'src/TemplateFunctions.php';

    /**
     * @var string
     */
    const HELPER_FUNCTIONS_FILEPATH = REZFUSION_PLUGIN_PATH . 'src/Helper/functions.php';

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        require_once static::TEMPLATE_FUNCTIONS_FILEPATH;
        require_once static::HELPER_FUNCTIONS_FILEPATH;
    }
}
