<?php

namespace Rezfusion\Registerer;

use Exception;
use Rezfusion\Actions;
use Rezfusion\Assets;
use Rezfusion\Helper\AssetsRegistererInterface;
use Rezfusion\Options;
use Rezfusion\OptionsHandler;
use Rezfusion\Provider\CustomHubConfigurationProvider;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Validator\HubConfigurationValidator;

class ComponentsBundleRegisterer implements RegistererInterface
{

    /**
     * @var bool
     */
    protected static $initialized = false;

    /**
     * @var string
     */
    const JAVASCRIPT_CONFIGURATION_VARIABLE_NAME = 'REZFUSION_COMPONENTS_BUNDLE_CONF';

    /**
     * @var string
     */
    const JAVASCRIPT_USER_DEFINED_CONFIGURATION_VARIABLE_NAME = 'REZFUSION_COMPONENTS_CONF';

    /**
     * @var AssetsRegistererInterface
     */
    protected $AssetsRegisterer;

    /**
     * @var OptionsHandler
     */
    protected $OptionsHandler;

    /**
     * @param AssetsRegistererInterface $AssetsRegisterer
     * @param OptionsHandler $OptionsHandler
     */
    public function __construct(AssetsRegistererInterface $AssetsRegisterer, OptionsHandler $OptionsHandler)
    {
        $this->AssetsRegisterer = $AssetsRegisterer;
        $this->OptionsHandler = $OptionsHandler;
    }

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        if (static::$initialized === true) {
            return;
        }

        add_action(Actions::wpHead(), function () {

            $this->AssetsRegisterer->handleScriptURL(plugins_url(Assets::localBundleScript()));
            $urlMap = new Template(Templates::mapTemplate());
            print $urlMap->render();

            if (!empty($componentsCSS_URL = $this->OptionsHandler->getOption(Options::componentsCSS_URL()))) {
                $this->AssetsRegisterer->handleStyleURL($componentsCSS_URL);
            }

            if (!empty($themeURL = $this->OptionsHandler->getOption(Options::themeURL()))) {
                $this->AssetsRegisterer->handleStyleURL($themeURL);
            }

            if (!empty($fontsURL = $this->OptionsHandler->getOption(Options::fontsURL()))) {
                $this->AssetsRegisterer->handleStyleURL($fontsURL);
            }

            $this->AssetsRegisterer->handleStyle(Assets::quickSearchStyle());

            $CustomConfiguration = CustomHubConfigurationProvider::getInstance();

            $HubConfigurationValidator = new HubConfigurationValidator();
            if ($HubConfigurationValidator->validate($CustomConfiguration) === false) {
                throw new Exception(join('/', $HubConfigurationValidator->getErrors()));
            }

            add_action(Actions::wpFooter(), function () use ($CustomConfiguration) {
                print "<script>window." . static::configurationVariableName() . " = " . json_encode($CustomConfiguration->getHubConfigurationArray()) . ";</script>";
            });
        });

        static::$initialized = true;
    }

    /**
     * @return string
     */
    public static function configurationVariableName(): string
    {
        return static::JAVASCRIPT_CONFIGURATION_VARIABLE_NAME;
    }

    /**
     * @return string
     */
    public static function userDefinedConfigurationVariableName(): string
    {
        return static::JAVASCRIPT_USER_DEFINED_CONFIGURATION_VARIABLE_NAME;
    }
}
