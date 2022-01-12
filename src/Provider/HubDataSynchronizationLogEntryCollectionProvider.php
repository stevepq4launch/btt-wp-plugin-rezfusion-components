<?php

namespace Rezfusion\Provider;

use Rezfusion\Helper\OptionManager;
use Rezfusion\LogEntryCollection;
use Rezfusion\Options;
use Rezfusion\Provider\ProviderInterface;

class HubDataSynchronizationLogEntryCollectionProvider implements ProviderInterface
{
    /**
     * @var LogEntryCollection
     */
    private static $LogEntryCollection;

    public static function getInstance()
    {
        if (!static::$LogEntryCollection) {
            static::$LogEntryCollection = new LogEntryCollection(Options::hubDataSynchronizationLog(), new OptionManager, 30);
        }
        return static::$LogEntryCollection;
    }
}
