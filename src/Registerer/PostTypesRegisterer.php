<?php

namespace Rezfusion\Registerer;

use Rezfusion\PostTypes;
use Rezfusion\PostTypes\VRListing;
use Rezfusion\PostTypes\VRPromo;

class PostTypesRegisterer implements RegistererInterface
{
    /**
     * @inheritdoc
     */
    public function register(): void
    {
        new VRListing(PostTypes::listing());
        new VRPromo(PostTypes::promo());
    }
}
