<?php

namespace Rezfusion\Factory;

use Exception;
use Rezfusion\Options;
use Rezfusion\PostRecentVisits;
use Rezfusion\SessionHandler\SessionHandler;

class PostRecentVisitsFactory implements MakeableInterface
{
    /**
     * Creates a new instance of PostRecentVisits.
     * @throws Exception
     * 
     * @return PostRecentVisits
     */
    public function make(): PostRecentVisits
    {
        if ($daysThreshold = intval(get_rezfusion_option(Options::urgencyAlertDaysThreshold())) < 1) {
            throw new Exception('Rezfusion Urgency Alert: Days threshold value must be greater than 0.');
        }
        return new PostRecentVisits($daysThreshold, SessionHandler::getInstance());
    }
}
