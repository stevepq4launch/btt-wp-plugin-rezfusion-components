<?php

namespace Rezfusion;

use Rezfusion\Entity\LogEntry;
use Rezfusion\Factory\LogEntryFromArrayFactory;
use Rezfusion\Helper\OptionManager;

class LogEntryCollection
{
    private $optionName;

    private $OptionManager;

    private $entries;

    private $maxEntries;

    /**
     * @var LogEntryFromArrayFactory
     */
    private $LogEntryFromArrayFactory;

    public function __construct($optionName = '', OptionManager $OptionManager, $maxEntries = 100)
    {
        $this->optionName = $optionName;
        $this->OptionManager = $OptionManager;
        $this->maxEntries = $maxEntries;
        $this->LogEntryFromArrayFactory = new LogEntryFromArrayFactory();
        $this->loadEntries();
    }

    public function loadEntries()
    {
        $entries = [];
        if (is_array($data = $this->OptionManager::get($this->optionName, []))) {
            foreach ($data as $entry) {
                $entries[] = $this->LogEntryFromArrayFactory->make($entry);
            }
        }
        $this->entries = $entries;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    private function limit()
    {
        if (count($this->entries) > $this->maxEntries) {
            array_splice($this->entries, 0, count($this->entries) - $this->maxEntries);
        }
    }

    public function addEntry(LogEntry $LogEntry)
    {
        $this->entries[] = $LogEntry;
        $this->limit();
    }

    public function save()
    {
        $this->limit();
        $entries = array_map(function ($LogEntry) {
            return $LogEntry->toArray();
        }, $this->entries);
        $this->OptionManager->update($this->optionName, $entries);
    }
}
