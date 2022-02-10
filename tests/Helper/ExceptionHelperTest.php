<?php

namespace Rezfusion\Helper\Registerer;

use Rezfusion\Helper\ExceptionHelper;
use Rezfusion\Tests\BaseTestCase;
use RuntimeException;
use stdClass;

class ExceptionHelperTest extends BaseTestCase
{
    public function testIsWordpressError(): void
    {
        $this->assertTrue(ExceptionHelper::isWordpressError(new \WP_Error));
        $this->assertFalse(ExceptionHelper::isWordpressError(new stdClass));
        $this->assertFalse(ExceptionHelper::isWordpressError(new RuntimeException('Fail')));
    }

    private function makeWordpressError(): \WP_Error
    {
        $errorMessage1 = "Test message #1.";
        $errorMessage2 = "Test message #2.";
        $Error = new \WP_Error(1, $errorMessage1);
        $Error->add(1, $errorMessage2);
        return $Error;
    }

    public function testGetMessagesFromWordpressError(): void
    {
        $Error = $this->makeWordpressError();
        $this->assertTrue(ExceptionHelper::isWordpressError($Error));
        $messages = ExceptionHelper::getMessagesFromWordpressError($Error);
        $this->assertIsArray($messages);
        $this->assertCount(2, $messages);
        $this->assertSame("Test message #1.", $messages[0]);
        $this->assertSame("Test message #2.", $messages[1]);
    }

    public function testGetMessagesFromWordpressErrorWithInvalidError(): void
    {
        $Error = new RuntimeException('Fail');
        $this->assertFalse(ExceptionHelper::isWordpressError($Error));
        $messages = ExceptionHelper::getMessagesFromWordpressError($Error);
        $this->assertIsArray($messages);
        $this->assertCount(0, $messages);
    }

    public function testMakeMessageFromWordpressError(): void
    {
        $Error = $this->makeWordpressError();
        $this->assertTrue(ExceptionHelper::isWordpressError($Error));
        $this->assertSame(
            "Test message #1. / Test message #2.",
            ExceptionHelper::makeMessageFromWordpressError($Error)
        );
    }

    public function testHandleWordpressError(): void
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage("Test message #1. / Test message #2.");
        $Error = $this->makeWordpressError();
        $this->assertTrue(ExceptionHelper::isWordpressError($Error));
        ExceptionHelper::handleWordpressError($Error);
    }

    public function testHandleWordpressErrorWithInvalidError(): void
    {
        $Error = new RuntimeException('Fail');
        $this->assertFalse(ExceptionHelper::isWordpressError($Error));
        $this->assertNull(ExceptionHelper::handleWordpressError($Error));
    }
}
