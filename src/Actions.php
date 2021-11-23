<?php

namespace Rezfusion;

class Actions
{
    /**
     * @var string
     */
    const INIT = 'init';

    /**
     * @var string
     */
    const ADMIN_ENQUEUE_SCRIPTS = 'admin_enqueue_scripts';

    /**
     * @var string
     */
    const WP_HEAD = 'wp_head';

    /**
     * @var string
     */
    const ADMIN_INIT = 'admin_init';

    /**
     * @var string
     */
    const TEMPLATE_REDIRECT = 'template_redirect';

    /**
     * @var string
     */
    const ADMIN_NOTICES = 'admin_notices';

    /**
     * @var string
     */
    const REST_API_INIT = 'rest_api_init';

    /**
     * @var string
     */
    const WP_FOOTER = 'wp_footer';

    /**
     * @var string
     */
    const ADMIN_MENU = 'admin_menu';

    /**
     * @var string
     */
    const ADD_META_BOXES = 'add_meta_boxes';

    /**
     * @var string
     */
    const SAVE_POST = 'save_post';

    /**
     * @var string
     */
    const ENQUEUE_SCRIPTS = 'wp_enqueue_scripts';

    /**
     * @return string
     */
    public static function init(): string
    {
        return static::INIT;
    }

    /**
     * @return string
     */
    public static function adminEnqueueScripts(): string
    {
        return static::ADMIN_ENQUEUE_SCRIPTS;
    }

    /**
     * @return string
     */
    public static function wpHead(): string
    {
        return static::WP_HEAD;
    }

    /**
     * @return string
     */
    public static function adminInit(): string
    {
        return static::ADMIN_INIT;
    }

    /**
     * @return string
     */
    public static function templateRedirect(): string
    {
        return static::TEMPLATE_REDIRECT;
    }

    /**
     * @return string
     */
    public static function adminNotices(): string
    {
        return static::ADMIN_NOTICES;
    }

    /**
     * @return string
     */
    public static function restAPI_Init(): string
    {
        return static::REST_API_INIT;
    }

    /**
     * @return string
     */
    public static function wpFooter(): string
    {
        return static::WP_FOOTER;
    }

    /**
     * @return string
     */
    public static function adminMenu(): string
    {
        return static::ADMIN_MENU;
    }

    /**
     * @return string
     */
    public static function addMetaBoxes(): string
    {
        return static::ADD_META_BOXES;
    }

    /**
     * @return string
     */
    public static function savePost(): string
    {
        return static::SAVE_POST;
    }

    /**
     * @param string $taxonomy
     * 
     * @return string
     */
    public static function taxonomyAddFormFields($taxonomy = ''): string
    {
        return "{$taxonomy}_add_form_fields";
    }

    /**
     * @param string $taxonomy
     * 
     * @return string
     */
    public static function createdTaxonomy($taxonomy = ''): string
    {
        return "created_{$taxonomy}";
    }

    /**
     * @param string $taxonomy
     * 
     * @return string
     */
    public static function taxonomyEditFormFields($taxonomy = ''): string
    {
        return "{$taxonomy}_edit_form_fields";
    }

    /**
     * @param string $taxonomy
     * 
     * @return string
     */
    public static function editedTaxonomy($taxonomy = ''): string
    {
        return "edited_{$taxonomy}";
    }

    /**
     * @param string $postType
     * 
     * @return string
     */
    public static function managePostTypePostsCustomColumn($postType = ''): string
    {
        return "manage_{$postType}_posts_custom_column";
    }

    /**
     * @return string
     */
    public static function enqueueScripts(): string
    {
        return static::ENQUEUE_SCRIPTS;
    }
}
