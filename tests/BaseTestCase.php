<?php

/**
 * @file - Provide a base class for test with database bootstrapping.
 */

namespace Rezfusion\Tests;

use PHPUnit\Framework\TestCase;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Tests\TestHelper\DatabaseHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class BaseTestCase extends TestCase
{
  /**
   * @var bool
   */
  private $refreshDatabaseAfterTest = false;

  /**
   * Returns full path to log file.
   * @return string
   */
  public static function logFile(): string
  {
    return getcwd() . '/test.log';
  }

  /**
   * Functions to execute before all tests.
   * @return void
   */
  public static function doBefore(): void
  {
  }

  /**
   * Functions to execute after all tests.
   * @return void
   */
  public static function doAfter(): void
  {
  }

  /**
   * Bootstrapping.
   * @return void
   */
  public static function bootstrap(): void
  {
    DatabaseHelper::bootstrapDatabase(static::getTestToken(), function (bool $newDatabaseCreated) {
      require_once(__DIR__ . "/../../../../wp-load.php");
      require_once(__DIR__ . "/../../../../wp-settings.php");
      if ($newDatabaseCreated === true) {
        static::refreshDatabaseData();
      }
    });
  }

  /**
   * Refresh data in database.
   * @return void
   */
  public static function refreshDatabaseData(): void
  {
    TestHelper::refreshData();
  }

  /**
   * Force data refresh after test is performed.
   * @return void
   */
  public function refreshDatabaseDataAfterTest(): void
  {
    $this->refreshDatabaseAfterTest = true;
  }

  /**
   * @inheritdoc
   * @return void
   */
  public static function setUpBeforeClass(): void
  {
    static::bootstrap();
    static::doBefore();
  }

  /**
   * @inheritdoc
   * @return void
   */
  public function setUp(): void
  {
    parent::setUp();
    $this->logTestInfo();
  }

  /**
   * @inheritdoc
   * @return void
   */
  public static function tearDownAfterClass(): void
  {
    static::doAfter();
  }

  /**
   * @inheritdoc
   * @return void
   */
  public function tearDown(): void
  {
    parent::tearDown();

    // https://github.com/sebastianbergmann/php-code-coverage/issues/708
    $_SERVER['REQUEST_TIME'] = (int) $_SERVER['REQUEST_TIME'];

    if ($this->refreshDatabaseAfterTest === true) {
      static::refreshDatabaseData();
      $this->refreshDatabaseDataAfterTest = false;
    }

    DeleteDataService::lock();
  }

  /**
   * Gets test token (provided by paratest).
   * @return string
   */
  public static function getTestToken(): string
  {
    return getenv('TEST_TOKEN');
  }

  /**
   * Checks if logging is enabled.
   * @return bool
   */
  private function isTestLogEnabled(): bool
  {
    return boolval(getenv('TEST_LOG'));
  }

  /**
   * Logs info about currently running test.
   * @return void
   */
  private function logTestInfo(): void
  {
    if ($this->isTestLogEnabled()) {
      file_put_contents(static::logFile(), sprintf("(%s) -- %s::%s\n", static::getTestToken(), static::class, $this->getName()), FILE_APPEND);
    }
  }
}
