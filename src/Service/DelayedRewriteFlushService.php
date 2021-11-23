<?php

namespace Rezfusion\Service;

use Rezfusion\Options;

class DelayedRewriteFlushService implements RunableInterface
{
    /**
     * @return boolean|void
     */
    public function run()
    {
        $optionName = Options::triggerRewriteFlush();
        if (!$option = get_rezfusion_option($optionName)) {
            return false;
        }
        if ($option == 1) {
            flush_rewrite_rules();
            delete_option($optionName);
        }
    }
}
