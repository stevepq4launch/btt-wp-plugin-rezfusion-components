<?php

namespace Rezfusion\Tests\Entity;

use Rezfusion\Entity\EntityInterface;
use Rezfusion\Entity\LogEntry;
use Rezfusion\Tests\BaseTestCase;

class LogEntryTest extends BaseTestCase
{
    /**
     * @var LogEntry
     */
    private $LogEntry;

    /**
     * @param LogEntry $LogEntry
     * @param string $statusMethod
     * @param string $statusConstant
     * @param string $expectedStatus
     * 
     * @return void
     */
    private function assertStatus(LogEntry $LogEntry, $statusMethod = '', $statusConstant = '', $expectedStatus = ''): void
    {
        $this->assertNotEmpty($statusMethod);
        $this->assertNotEmpty($statusConstant);
        $this->assertNotEmpty($expectedStatus);
        $this->assertIsString($LogEntry->failStatus());
        $this->assertSame($expectedStatus, $this->LogEntry->$statusMethod());
        $this->assertSame($expectedStatus, constant(LogEntry::class . '::' . $statusConstant));
    }

    private function makeLogEntry(): LogEntry
    {
        $LogEntry = new LogEntry;
        $this->assertInstanceOf(LogEntry::class, $LogEntry);
        $this->assertInstanceOf(EntityInterface::class, $LogEntry);
        return $LogEntry;
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->LogEntry = $this->makeLogEntry();
    }

    public function testFailStatus(): void
    {
        $this->assertIsString($this->LogEntry->failStatus());
        $this->assertSame('fail', $this->LogEntry->failStatus());
        $this->assertSame($this->LogEntry::FAIL_STATUS, $this->LogEntry->failStatus());
        $this->assertSame(LogEntry::FAIL_STATUS, $this->LogEntry->failStatus());
        $this->assertStatus($this->LogEntry, 'failStatus', 'FAIL_STATUS', 'fail');
    }

    public function testSuccessStatus(): void
    {
        $this->assertIsString($this->LogEntry->failStatus());
        $this->assertSame('success', $this->LogEntry->successStatus());
        $this->assertSame('success', $this->LogEntry::SUCCESS_STATUS);
        $this->assertSame('success', LogEntry::SUCCESS_STATUS);
        $this->assertSame($this->LogEntry::SUCCESS_STATUS, $this->LogEntry->successStatus());
        $this->assertSame(LogEntry::SUCCESS_STATUS, $this->LogEntry->successStatus());
    }

    public function testIdGetterAndSetter(): void
    {
        $id = 1000;
        $this->assertNull($this->LogEntry->getId());
        $this->assertIsObject($this->LogEntry->setId($id));
        $this->assertIsInt($this->LogEntry->getId());
        $this->assertSame($id, $this->LogEntry->getId());
    }

    public function testMessageGetterAndSetter(): void
    {
        $message = 'Test message.';
        $this->assertNull($this->LogEntry->getMessage());
        $this->assertIsObject($this->LogEntry->setMessage($message));
        $this->assertIsScalar($this->LogEntry->getMessage());
        $this->assertSame($message, $this->LogEntry->getMessage());
    }

    public function testDateGetterAndSetter(): void
    {
        $date = date('Y-m-d');
        $this->assertNull($this->LogEntry->getDate());
        $this->assertIsObject($this->LogEntry->setDate($date));
        $this->assertIsScalar($this->LogEntry->getDate());
        $this->assertSame($date, $this->LogEntry->getDate());
    }

    public function testStatusGetterAndSetter(): void
    {
        $status = LogEntry::SUCCESS_STATUS;
        $this->assertNull($this->LogEntry->getStatus());
        $this->assertIsObject($this->LogEntry->setStatus($status));
        $this->assertIsScalar($this->LogEntry->getStatus());
        $this->assertSame($status, $this->LogEntry->getStatus());
    }

    public function testToArray(): void
    {
        $data = [
            'id' => 1001,
            'message' => 'Test message.',
            'status' => LogEntry::FAIL_STATUS,
            'date' => date('Y-m-d')
        ];
        $this->LogEntry->setId($data['id']);
        $this->LogEntry->setStatus($data['status']);
        $this->LogEntry->setDate($data['date']);
        $this->LogEntry->setMessage($data['message']);
        $array = $this->LogEntry->toArray();
        $this->assertIsArray($array);
        $this->assertSame($data, $array);
    }
}
