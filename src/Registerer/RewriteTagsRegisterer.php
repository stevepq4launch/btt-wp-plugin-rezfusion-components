<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;

class RewriteTagsRegisterer implements RegistererInterface
{
    /**
     * Add a rewrite tag for the query parameter that components uses to
     * identify items in the API.
     * 
     * @inheritdoc
     */
    public function register(): void
    {
        add_action(Actions::init(), function () {
            add_rewrite_tag('%pms_id%', '([^&]+)');
        });
    }
}
