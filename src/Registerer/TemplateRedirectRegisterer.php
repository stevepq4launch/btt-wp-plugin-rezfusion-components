<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Repository\ItemRepository;

class TemplateRedirectRegisterer implements RegistererInterface
{
    /**
     * Redirect users to the property details page.
     *
     * @todo: Probably deprecate this.
     * @todo: As I suspect there is a more "wordpress-y" way to do this.
     * 
     * @inheritdoc
     */
    public function register(): void
    {
        add_action(Actions::templateRedirect(), function () {
            $redirect = get_rezfusion_option(Options::redirectUrls());
            $repository = new ItemRepository(Plugin::apiClient());
            if ($redirect && isset($_GET['pms_id'])) {
                $id = sanitize_text_field($_GET['pms_id']);
                $posts = $repository->getItemById($id);
                if (!empty($posts) && $link = get_permalink($posts[0]['post_id'])) {
                    wp_redirect($link, 301);
                    exit();
                }
            }
        });
    }
}
