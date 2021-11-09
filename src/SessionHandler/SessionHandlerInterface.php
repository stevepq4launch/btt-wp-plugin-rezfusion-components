<?php

namespace Rezfusion\SessionHandler;

interface SessionHandlerInterface
{
    public function startSession();
    public function getSessionId();
    public function stopSession();
}
