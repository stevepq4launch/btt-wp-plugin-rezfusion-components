<?php

namespace Rezfusion\Helper;

interface AssetsRegistererInterface
{
    public function handleStyle($source = '', array $dependencies = [], $version = false, $media = 'all'): string;
    public function handleScript($source = '', array $dependencies = [], $version = false, $inFooter = false): string;
    public function handleStyleURL($source = '', $dependencies = [], $version = false, $media = 'all'): string;
    public function handleScriptURL($source = '', $dependencies = [], $version = false, $inFooter = false): string;
}
