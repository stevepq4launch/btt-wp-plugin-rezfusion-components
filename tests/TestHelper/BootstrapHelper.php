<?php

namespace Rezfusion\Tests\TestHelper;

use Rezfusion\Configuration\ConfigurationStorage\JSON_ConfigurationStorage;
use Rezfusion\Configuration\ConfigurationStorage\RemoteConfigurationStorage;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationUpdater;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Tests\BaseTestCase;
use RuntimeException;

class BootstrapHelper
{
    /**
     * Returns path to file with hub configuration.
     * @return string
     */
    public static function hubConfigurationStorageFile(): string
    {
        return getcwd() . "/rzftest-hub-config.json";
    }

    /**
     * Returns array of temporary files.
     * @return array
     */
    private static function getTemporaryFiles(): array
    {
        return [
            static::hubConfigurationStorageFile(),
            BaseTestCase::logFile(),
            './test-api-cache.json',
            './json-storage-test.json',
            './file-cache-test.json',
            DatabaseHelper::databaseConfigurationFile()
        ];
    }

    /**
     * Delete temporary files like cache, storage, etc.
     * @return void
     */
    private static function deleteTemporaryFiles(): void
    {
        foreach (static::getTemporaryFiles() as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Delete unneeded databases.
     * @param string $nameLike
     *
     * @return void
     */
    private static function deleteTemporaryDatabases($nameLike = ''): void
    {
        global $wpdb;
        $drops = $wpdb->get_results("SELECT CONCAT('DROP DATABASE `', SCHEMA_NAME, '`;') FROM `information_schema`.`SCHEMATA` WHERE SCHEMA_NAME LIKE '${nameLike}';", ARRAY_N);
        foreach ($drops as $sql) {
            $wpdb->query($sql[0]);
        }
    }

    /**
     * Creates database configuration file to be used during tests.
     * @return void
     */
    private static function prepareDatabaseConfiguration(): void
    {
        DatabaseHelper::saveDatabaseConfigurationToFile(
            DatabaseHelper::makeWordpressDatabaseConfigurationString(),
            DatabaseHelper::databaseConfigurationFile()
        );
    }

    /**
     * Modify Wordpress configuration file to adapt it for tests.
     * @return void
     */
    private static function fixWordpressConfigurationFile(): void
    {
        $configFilePath = ABSPATH . '/wp-config.php';
        if (!file_exists($configFilePath)) {
            throw new RuntimeException("Wordpress configuration file doesn't exist.");
        }
        $config = file_get_contents($configFilePath);
        if (empty($config)) {
            throw new RuntimeException("Invalid Wordpress configuration.");
        }
        $fixedConfiguration = preg_replace(
            '/^define\( \'DB_NAME\'\, \'wordpress\' \);$/m',
            "if ( ! defined( 'REZFUSION_TEST' ) ) {\n\tdefine( 'DB_NAME', 'wordpress' );\n}",
            $config
        );
        if ($fixedConfiguration !== $config) {
            file_put_contents($configFilePath, $fixedConfiguration);
        }
    }

    /**
     * Prepare hub configuration storage to be used during tests.
     * @return void
     */
    private static function prepareHubConfigurationStorage(): void
    {
        $file = static::hubConfigurationStorageFile();
        if (file_exists($file)) {
            throw new RuntimeException('Hub configuration file should not exist.');
        }
        touch($file);
        $HubConfiguration = new HubConfiguration(
            OptionManager::get(Options::componentsURL()),
            new JSON_ConfigurationStorage($file)
        );
        $HubConfigurationUpdater = new HubConfigurationUpdater(
            $HubConfiguration,
            new RemoteConfigurationStorage($HubConfiguration->getComponentsURL(), get_class($HubConfiguration))
        );
        if ($HubConfigurationUpdater->update() === false) {
            throw new RuntimeException('Hub configuration update failed.');
        }
        $HubConfiguration->saveConfiguration();
    }

    /**
     * Bootstrap and setup before running tests.
     * @return void
     */
    public static function bootstrap(): void
    {
        static::deleteTemporaryFiles();
        static::deleteTemporaryDatabases(DatabaseHelper::testDatabasePrefix() . '%');
        static::fixWordpressConfigurationFile();
        static::prepareDatabaseConfiguration();
        static::prepareHubConfigurationStorage();
    }
}
