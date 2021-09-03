<?php

namespace Rezfusion\SessionHandler;

class SessionHandler implements SessionHandlerInterface
{
    /**
     * @var self
     */
    protected static $Instance;

    /**
     * @return SessionHandler
     */
    public static function getInstance()
    {
        if (empty(self::$Instance))
            self::$Instance = new SessionHandler;
        return self::$Instance;
    }

    public function startSession()
    {
        session_start();
    }

    public function stopSession()
    {
        session_destory();
    }

    public function getSessionId()
    {
        return session_id();
    }
}
