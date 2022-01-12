<?php

namespace Rezfusion\Factory;

use Rezfusion\Entity\LogEntry;

class LogEntryFromArrayFactory
{
    public function make(array $data): LogEntry
    {
        $message = 'message';
        $date = 'date';
        $status = 'status';
        $LogEntry = new LogEntry();

        if (array_key_exists($message, $data)) {
            $LogEntry->setMessage($data[$message]);
        }

        if (array_key_exists($date, $data)) {
            $LogEntry->setDate($data[$date]);
        }

        if (array_key_exists($status, $data)) {
            $LogEntry->setStatus($data[$status]);
        }

        return $LogEntry;
    }
}
