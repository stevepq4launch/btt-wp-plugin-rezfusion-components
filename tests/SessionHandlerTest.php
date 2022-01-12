<?php

namespace Rezfusion\Tests;

use Rezfusion\SessionHandler\SessionHandler;
use Rezfusion\SessionHandler\SessionHandlerInterface;

class SessionHandlerTest extends BaseTestCase
{
    /**
     * @var SessionHandlerInterface
     */
    private $SessionHandler;

    public function setUp(): void
    {
        parent::setUp();
        $this->SessionHandler = SessionHandler::getInstance();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testStartSession()
    {
        $this->SessionHandler->startSession();
        $sessionId = $this->SessionHandler->getSessionId();
        $this->assertNotEmpty($sessionId);
        $this->assertIsString($sessionId);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testStopSession()
    {
        $this->testStartSession();
        $sessionId = $this->SessionHandler->getSessionId();
        $this->SessionHandler->stopSession();
        $sessionId = $this->SessionHandler->getSessionId();
        $this->assertEmpty($sessionId);
    }
}
