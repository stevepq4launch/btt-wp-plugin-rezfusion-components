<?php

namespace Rezfusion\Validator;

use Rezfusion\Configuration\HubConfiguration;

class HubConfigurationValidator
{
    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * @param HubConfiguration $HubConfiguration
     * 
     * @return bool
     */
    public function validate(HubConfiguration $HubConfiguration): bool
    {
        $this->errors = [];

        if (empty($HubConfiguration->getChannelURL())) {
            $this->errors[] = "Invalid channel domain/URL.";
        }

        if (empty($HubConfiguration->getComponentsURL())) {
            $this->errors[] = "Invalid components URL.";
        }

        if (empty($HubConfiguration->getBlueprintURL())) {
            $this->errors[] = "Invalid blueprint URL.";
        }

        if (empty($HubConfiguration->getMapAPI_Key())) {
            $this->errors[] = "Invalid API key.";
        }

        if (empty($HubConfiguration->getSPS_Domain())) {
            $this->errors[] = "Invalid SPS domain/URL.";
        }

        return !count($this->getErrors()) ? true : false;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
