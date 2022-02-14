<?php

namespace Rezfusion\Tests\TestHelper;

use InvalidArgumentException;
use RuntimeException;

class DatabaseHelper
{
    /**
     * @return string
     */
    public static function databaseNameConstant(): string
    {
        return 'DB_NAME';
    }

    /**
     * @return string
     */
    public static function databaseName(): string
    {
        return constant('RZFTEST_DB_NAME');
    }

    /**
     * @return string
     */
    public static function databaseUser(): string
    {
        return constant('RZFTEST_DB_USER');
    }

    /**
     * @return string
     */
    public static function databasePassword(): string
    {
        return constant('RZFTEST_DB_PASSWORD');
    }

    /**
     * @return string
     */
    public static function databaseHost(): string
    {
        return constant('RZFTEST_DB_HOST');
    }

    /**
     * Path to database configuration file.
     * @return string
     */
    public static function databaseConfigurationFile(): string
    {
        return getcwd()  . '/rzftest-wp-config.php';
    }

    /**
     * @return string
     */
    public static function testDatabasePrefix(): string
    {
        return 'rzftest_';
    }

    /**
     * @return string
     */
    public static function mysqlDatabaseParametersString(): string
    {
        return sprintf('-u%s -p%s -h%s', static::databaseUser(), static::databasePassword(), static::databaseHost());
    }

    /**
     * @param string $databaseName
     * 
     * @return void
     */
    public static function deleteDatabase($databaseName = ''): void
    {
        if (empty($databaseName)) {
            throw new InvalidArgumentException('Invalid database name.');
        }
        exec('echo "DROP DATABASE ' . $databaseName . ';" | mysql ' . static::mysqlDatabaseParametersString());
    }

    /**
     * @return bool
     */
    public static function checkMysql(): bool
    {
        return boolval(`which mysql`);
    }

    /**
     * @return string
     */
    public static function mysqlCommandString(): string
    {
        return "mysql " . static::mysqlDatabaseParametersString();
    }

    /**
     * @return bool
     */
    public static function copyDatabase($sourceDatabaseName = '', $targetDatabaseName = ''): bool
    {
        return boolval(exec("mysqldump -q -C " . static::mysqlDatabaseParametersString() . " $sourceDatabaseName | " . static::mysqlCommandString() . " -C $targetDatabaseName"));
    }

    /**
     * @return bool
     */
    public static function createDatabase($databaseName = ''): bool
    {
        return boolval(exec(sprintf('echo "CREATE DATABASE IF NOT EXISTS %s" | %s', $databaseName, static::mysqlCommandString())));
    }

    /**
     * Check if database exists.
     * @param string $databaseName
     * 
     * @return bool
     */
    public static function databaseExists($databaseName = ''): bool
    {
        return boolval(exec(sprintf('echo "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = \'%s\'" | %s', $databaseName, static::mysqlCommandString())));
    }

    /**
     * Define global constant with database name to be used during tests.
     * @param string $databaseName
     * 
     * @return void
     */
    public static function defineDatabase($databaseName = ''): void
    {
        define(static::databaseNameConstant(), $databaseName);
    }

    /**
     * @param string $sourceDatabaseName
     * @param string $newDatabaseName
     * 
     * @return bool
     */
    public static function handleDatabaseCopy($sourceDatabaseName, $newDatabaseName): bool
    {
        if (!static::checkMysql()) {
            throw new RuntimeException('No mysql command.');
        }
        if (empty($sourceDatabaseName)) {
            throw new InvalidArgumentException('Invalid database name(s).');
        }
        if (!static::databaseExists($newDatabaseName)) {
            static::createDatabase($newDatabaseName);
            static::copyDatabase($sourceDatabaseName, $newDatabaseName);
            return true;
        }
        return false;
    }

    /**
     * Creates configuration (as string) based on Wordpress database config params.
     * @return string
     */
    public static function makeWordpressDatabaseConfigurationString(): string
    {
        return
            "<?php\n\n"
            . array_reduce(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST'], function ($carry, $item) {
                $carry .= sprintf("define('RZFTEST_%s', '%s');\n", $item, constant($item));
                return $carry;
            }, '')
            . "\n";
    }

    /**
     * Saves passed configuration to specified file.
     * @param string $configuration
     * @param string $file
     * 
     * @return int|bool
     */
    public static function saveDatabaseConfigurationToFile($configuration, $file)
    {
        return file_put_contents($file, $configuration);
    }

    /**
     * @param string $expectedDatabaseName
     * @throws RuntimeException
     * 
     * @return void
     */
    public static function validateCurrentDatabase($expectedDatabaseName = ''): void
    {
        $databaseNameConstant = static::databaseNameConstant();
        if (!defined($databaseNameConstant)) {
            throw new RuntimeException('Database name not defined.');
        }
        $currentDatabaseName = constant($databaseNameConstant);
        if (
            empty($currentDatabaseName)
            || strpos($currentDatabaseName, static::testDatabasePrefix()) !== 0
            || $currentDatabaseName !== $expectedDatabaseName
        ) {
            throw new RuntimeException('Invalid database.');
        }
    }

    /**
     * Initialize database.
     * @param string $testToken
     * @param null|callable $callback
     * 
     * @return void
     */
    public static function bootstrapDatabase($testToken = '', $callback = null): void
    {
        $databaseConstant = static::databaseNameConstant();
        $databasePrefix = static::testDatabasePrefix();
        $sourceDatabaseName = static::databaseName();

        if (empty($sourceDatabaseName)) {
            throw new RuntimeException('Invalid source database name.');
        }

        if (empty($testToken)) {
            throw new RuntimeException('Invalid test token.');
        }

        $targetDatabaseName = $databasePrefix . $testToken;
        $newDatabaseCreated = false;

        if (!defined($databaseConstant)) {
            $newDatabaseCreated = static::handleDatabaseCopy($sourceDatabaseName, $targetDatabaseName);
            DatabaseHelper::defineDatabase($targetDatabaseName);
        }

        if (is_callable($callback)) {
            $callback($newDatabaseCreated);
        }

        static::validateCurrentDatabase($targetDatabaseName);
    }
}
