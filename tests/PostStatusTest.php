<?php

namespace Rezfusion\Tests;

use Rezfusion\PostStatus;

class PostStatusTest extends BaseTestCase
{
    public function testPublishStatus(): void
    {
        $this->assertSame('publish', PostStatus::publishStatus());
    }

    public function testDraftStatus(): void
    {
        $this->assertSame('draft', PostStatus::draftStatus());
    }

    public function testTrashStatus(): void
    {
        $this->assertSame('trash', PostStatus::trashStatus());
    }
}
