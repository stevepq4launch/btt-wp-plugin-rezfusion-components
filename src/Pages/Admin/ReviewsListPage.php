<?php

namespace Rezfusion\Pages\Admin;

use Rezfusion\Pages\Page;

class ReviewsListPage extends Page
{
    /**
     * @var string
     */
    const PAGE_NAME = 'rezfusion_components_reviews_list';

    /**
     * @inheritdoc
     */
    public function display(): void
    {
        print $this->template->render();
    }
}
