<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Client\ClientInterface;
use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Factory\MakeableInterface;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Service\PropertiesPermalinksMapRebuildService;
use Rezfusion\Service\RunableInterface;

class PropertyPage404FixRegisterer implements RegistererInterface
{
    /**
     * @var MakeableInterface
     */
    private $API_ClientFactory;

    /**
     * @param MakeableInterface $API_Client
     */
    public function __construct(MakeableInterface $API_ClientFactory)
    {
        $this->API_ClientFactory = $API_ClientFactory;
    }

    private function makePropertiesPermalinksMapRebuildService(): RunableInterface
    {
        $API_Client = $this->API_ClientFactory->make();
        $properties = $API_Client->getItems(Plugin::getInstance()->getOption(Options::hubChannelURL()));
        return (new PropertiesPermalinksMapRebuildService(
            (isset($properties->data->lodgingProducts->results) && !empty($properties->data->lodgingProducts->results))
                ? $properties->data->lodgingProducts->results
                : [],
            new ItemRepository($API_Client)
        ));
    }

    private function handlePropertyPage404(): void
    {
        if (!is_404() || empty($url = $_SERVER['REQUEST_URI']))
            return;

        $slug = Plugin::getInstance()->getOption(Options::customListingSlug());

        if (strpos($url, '/' . $slug . '?pms_id') !== 0)
            return;

        $propertyKey = (isset($_GET['pms_id']) && !empty($_GET['pms_id'])) ? $_GET['pms_id'] : null;

        if (empty($propertyKey))
            return;

        $this->makePropertiesPermalinksMapRebuildService()->run();

        $urlsMap = get_transient(Options::URL_Map(), []);
        if (isset($urlsMap[$propertyKey])) {
            wp_redirect(
                trim($urlsMap[$propertyKey], '/')
                    . (!empty(@$_SERVER['QUERY_STRING'])
                        ? '?' . $_SERVER['QUERY_STRING']
                        : '')
            );
        }
    }

    public function register(): void
    {
        add_action(Actions::templateRedirect(), function () {
            $this->handlePropertyPage404();
        });
    }
}
