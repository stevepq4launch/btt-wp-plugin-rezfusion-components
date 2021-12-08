<?php

namespace Rezfusion\Tests\Registerer;

use Rezfusion\Helper\AssetsRegisterer;

class TestableAssetsRegisterer extends AssetsRegisterer
{
    public function testHandle($handle = '', $source = '', $type = '', $dependencies = [], $version = false, $inFooter = true, $media = 'all'): string
    {
        return $this->handle($handle, $source, $type, $dependencies, $version, $inFooter, $media);
    }
}
