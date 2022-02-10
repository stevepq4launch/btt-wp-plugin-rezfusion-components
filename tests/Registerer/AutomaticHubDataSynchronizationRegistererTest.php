<?php

namespace Rezfusion\Tests\Registerer;

use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Registerer\AutomaticHubDataSynchronizationRegisterer;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class AutomaticHubDataSynchronizationRegistererTest extends BaseTestCase
{
    /**
     * @return AutomaticHubDataSynchronizationRegisterer
     */
    private function makeRegisterer(): AutomaticHubDataSynchronizationRegisterer
    {
        return new AutomaticHubDataSynchronizationRegisterer();
    }

    private function isEventScheduled()
    {
        return wp_next_scheduled(AutomaticHubDataSynchronizationRegisterer::hookName());
    }

    private static function deleteCronData(): void
    {
        OptionManager::delete(Options::cron());
    }

    public function testHookName(): void
    {
        $this->assertSame('rzf_automatic_sync', AutomaticHubDataSynchronizationRegisterer::hookName());
    }

    public function testInterval(): void
    {
        $this->assertSame('hourly', AutomaticHubDataSynchronizationRegisterer::interval());
    }

    public function testRegister(): void
    {
        $this->deleteCronData();
        $this->assertFalse($this->isEventScheduled());
        $this->assertNull($this->makeRegisterer()->register());
        $this->assertIsInt($this->isEventScheduled());
    }

    public function testUnscheduleEvent(): void
    {
        $this->deleteCronData();
        $Registerer = $this->makeRegisterer();
        $this->assertFalse($this->isEventScheduled());
        $this->assertNull($Registerer->register());
        $this->assertIsInt($this->isEventScheduled());
        $Registerer->unscheduleEvent();
        $this->assertFalse($this->isEventScheduled());
    }

    public function testHook(): void
    {
        $this->refreshDatabaseDataAfterTest();
        $this->deleteCronData();
        $this->makeRegisterer()->register();
        $this->assertIsInt($this->isEventScheduled());
        DeleteDataService::unlock();
        (new DeleteDataService)->run();
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $this->assertCount(0, $ItemRepository->getAllItemsIds());
        do_action(AutomaticHubDataSynchronizationRegisterer::hookName());
        $this->assertGreaterThan(PropertiesHelper::minPropertiesCountInHub(), $ItemRepository->getAllItemsIds());
    }

    public function testRegisterDeactivation(): void
    {
        $this->deleteCronData();
        $this->makeRegisterer()->register();
        $this->assertIsInt($this->isEventScheduled());
        do_action('deactivate_' . plugin_basename(REZFUSION_PLUGIN));
        $this->assertFalse($this->isEventScheduled());
    }
}
