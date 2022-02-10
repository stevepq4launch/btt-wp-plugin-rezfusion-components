<?

namespace Rezfusion\Tests;

use Rezfusion\Entity\LogEntry;
use Rezfusion\Helper\OptionManager;
use Rezfusion\LogEntryCollection;

class LogEntryCollectionTest extends BaseTestCase
{
    /**
     * @var string
     */
    const OPTION_NAME = 'log-entry-collection-test';

    /**
     * @var int
     */
    const MAX_ENTRIES = 5;

    /**
     * @var LogEntryCollection
     */
    private $LogEntryCollection;

    /**
     * @return LogEntryCollection
     */
    private function makeLogEntryCollection(): LogEntryCollection
    {
        return new LogEntryCollection(static::OPTION_NAME, new OptionManager, static::MAX_ENTRIES);
    }

    /**
     * @param string $message
     * 
     * @return LogEntry
     */
    private function makeLogEntry($message = ''): LogEntry
    {
        $LogEntry = new LogEntry();
        $LogEntry->setMessage($message);
        return $LogEntry;
    }

    /**
     * @param LogEntry[] $entries
     * @param int $count
     * 
     * @return void
     */
    private function assertEntries(array $entries = [], int $count = 0): void
    {
        $this->assertIsArray($entries);
        $this->assertCount($count, $entries);
        if (count($entries) > 0) {
            $this->assertNotEmpty($entries[0]);
            $this->assertInstanceOf(LogEntry::class, $entries[0]);
        }
    }

    /**
     * @param LogEntry[] $entries
     * 
     * @return void
     */
    private function assertEntriesForLimitTest(array $entries = []): void
    {
        $this->assertEntries($entries, 5);
        for ($i = 0; $i < 5; $i++) {
            $this->assertSame('test' . ($i + 6), $entries[$i]->getMessage());
        }
    }

    /**
     * @param LogEntry[] $entries
     * @param string $firstEntryMessage
     * @param string $secondEntryMessage
     * 
     * @return void
     */
    private function assertEntriesForLoadEntriesAfterSaveTest(array $entries = [], $firstEntryMessage = '', $secondEntryMessage = ''): void
    {
        $this->assertEntries($entries, 2);
        $this->assertSame($firstEntryMessage, $entries[0]->getMessage());
        $this->assertSame($secondEntryMessage, $entries[1]->getMessage());
    }

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->LogEntryCollection = $this->makeLogEntryCollection();
    }

    public function testAddEntry(): void
    {
        $LogEntryCollection = $this->makeLogEntryCollection();
        $LogEntry = $this->makeLogEntry('test message');
        $this->assertCount(0, $LogEntryCollection->getEntries());
        $LogEntryCollection->addEntry($LogEntry);
        $entries = $LogEntryCollection->getEntries();
        $this->assertCount(1, $entries);
        $this->assertSame('test message', $entries[0]->getMessage());
    }

    public function testAddEntryWithInvalidEntry(): void
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Argument 1 passed to Rezfusion\LogEntryCollection::addEntry() must be an instance of Rezfusion\Entity\LogEntry, null given');
        $this->LogEntryCollection->addEntry(null);
    }

    public function testLoadEntries(): void
    {
        $this->assertEntries($this->LogEntryCollection->getEntries(), 0);
        $LogEntry = $this->makeLogEntry();
        $this->LogEntryCollection->addEntry($LogEntry);
        $this->LogEntryCollection->addEntry($LogEntry);
        $this->assertEntries($this->LogEntryCollection->getEntries(), 2);
        $this->LogEntryCollection->loadEntries();
        $this->assertEntries($this->LogEntryCollection->getEntries(), 0);
    }

    public function testLoadEntriesAfterSave(): void
    {
        $firstEntryMessage = 'test1';
        $secondEntryMessage = 'test2';

        $this->assertEntries($this->LogEntryCollection->getEntries(), 0);
        $this->LogEntryCollection->addEntry($this->makeLogEntry($firstEntryMessage));
        $this->LogEntryCollection->addEntry($this->makeLogEntry($secondEntryMessage));

        $this->assertEntriesForLoadEntriesAfterSaveTest(
            $this->LogEntryCollection->getEntries(),
            $firstEntryMessage,
            $secondEntryMessage
        );

        $this->LogEntryCollection->save();
        $this->LogEntryCollection->loadEntries();

        $this->assertEntriesForLoadEntriesAfterSaveTest(
            $this->LogEntryCollection->getEntries(),
            $firstEntryMessage,
            $secondEntryMessage
        );
    }

    public function testLimit(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->LogEntryCollection->addEntry($this->makeLogEntry("test${i}"));
        }
        $this->assertEntriesForLimitTest($this->LogEntryCollection->getEntries());
        $this->LogEntryCollection->save();
        $this->LogEntryCollection->loadEntries();
        $this->assertEntriesForLimitTest($this->LogEntryCollection->getEntries());
    }

    /**
     * @inheritdoc
     */
    public function tearDown(): void
    {
        parent::tearDown();
        OptionManager::delete(static::OPTION_NAME);
    }
}
