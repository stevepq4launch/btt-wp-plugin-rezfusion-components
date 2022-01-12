<?php

namespace Rezfusion\Registerer;

use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Plugin;
use Rezfusion\Service\DataRefreshService;
use Rezfusion\Service\RunableInterface;

class AutomaticHubDataSynchronizationRegisterer implements RegistererInterface
{
    /**
     * @var RunableInterface
     */
    private $DataRefreshService;

    public static function hookName(): string
    {
        return Plugin::prefix() . '_automatic_sync';
    }

    public static function interval(): string
    {
        return 'hourly';
    }

    private function eventIsScheduled()
    {
        return wp_next_scheduled(static::hookName());
    }

    private function scheduleEvent()
    {
        return wp_schedule_event(time(), static::interval(), static::hookName());
    }

    public function unscheduleEvent(): void
    {
        wp_unschedule_event(wp_next_scheduled(static::hookName()), static::hookName());
    }

    private function registerDeactivation(): void
    {
        register_deactivation_hook(REZFUSION_PLUGIN, function () {
            $this->unscheduleEvent();
        });
    }

    private function registerHook(): void
    {
        add_action(static::hookName(), function () {
            $this->DataRefreshService = new DataRefreshService((new API_ClientFactory)->make(), true);
            $this->DataRefreshService->run();
        });
    }

    public function register(): void
    {
        $this->registerHook();
        if (!$this->eventIsScheduled()) {
            $this->scheduleEvent();
        }
        $this->registerDeactivation();
    }
}
