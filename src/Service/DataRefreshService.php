<?php

namespace Rezfusion\Service;

use Rezfusion\Client\Cache;
use Rezfusion\Client\ClientInterface;
use Rezfusion\Options;
use Rezfusion\Repository\CategoryRepository;
use Rezfusion\Repository\ItemRepository;

class DataRefreshService implements RunableInterface
{

    /**
     * @var ClientInterface
     */
    private $API_Client;

    /**
     * @param ClientInterface $API_Client
     */
    public function __construct(ClientInterface $API_Client)
    {
        $this->API_Client = $API_Client;
    }

    /**
     * Execute data refresh operation.
     * 
     * @return void
     */
    public function run(): void
    {
        // During a refresh cycle, we want to skip the read on cache hits.
        // But still write during the end of the cycle.
        $cache = $this->API_Client->getCache();
        $mode = $cache->getMode();
        $cache->setMode(Cache::MODE_WRITE);
        $channel = get_rezfusion_option(Options::hubChannelURL());
        $repository = new ItemRepository($this->API_Client);
        $categoryRepository = new CategoryRepository($this->API_Client);
        // Prioritize category updates so that taxonomy IDs/information is
        // available during item updates.
        $categoryRepository->updateCategories($channel);
        $repository->updateItems($channel);

        (new RemoveRedundantCategoriesService)->run(
            $categoryRepository,
            $categoryRepository->getCategories(),
            $this->API_Client->getCategories($channel)
        );

        // Restore the cache mode to the previous setting
        // just in case processing will continue after this step.
        $cache->setMode($mode);
    }
}
