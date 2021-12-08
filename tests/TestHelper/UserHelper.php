<?php

namespace Rezfusion\Tests\TestHelper;

use RuntimeException;

class UserHelper
{

    const USER_TEMPLATE = <<<TESTER
{
    "data": {
        "ID": "-1",
        "user_login": "tester",
        "user_pass": "",
        "user_nicename": "tester",
        "user_email": "tester@localhost",
        "user_url": "http://localhost:8080",
        "user_registered": "",
        "user_activation_key": "",
        "user_status": "0",
        "display_name": "tester"
    },
    "ID": -1,
    "caps": { "administrator": false },
    "cap_key": "wp_capabilities",
    "roles": ["tester"],
    "allcaps": {
        "switch_themes": false,
        "edit_themes": false,
        "activate_plugins": false,
        "edit_plugins": false,
        "edit_users": false,
        "edit_files": false,
        "manage_options": false,
        "moderate_comments": false,
        "manage_categories": false,
        "manage_links": false,
        "upload_files": false,
        "import": false,
        "unfiltered_html": false,
        "edit_posts": false,
        "edit_others_posts": false,
        "edit_published_posts": false,
        "publish_posts": false,
        "edit_pages": false,
        "read": false,
        "level_10": false,
        "level_9": false,
        "level_8": false,
        "level_7": false,
        "level_6": false,
        "level_5": false,
        "level_4": false,
        "level_3": false,
        "level_2": false,
        "level_1": false,
        "level_0": false,
        "edit_others_pages": false,
        "edit_published_pages": false,
        "publish_pages": false,
        "delete_pages": false,
        "delete_others_pages": false,
        "delete_published_pages": false,
        "delete_posts": false,
        "delete_others_posts": false,
        "delete_published_posts": false,
        "delete_private_posts": false,
        "edit_private_posts": false,
        "read_private_posts": false,
        "delete_private_pages": false,
        "edit_private_pages": false,
        "read_private_pages": false,
        "delete_users": false,
        "create_users": false,
        "unfiltered_upload": false,
        "edit_dashboard": false,
        "update_plugins": false,
        "delete_plugins": false,
        "install_plugins": false,
        "update_themes": false,
        "install_themes": false,
        "update_core": false,
        "list_users": false,
        "remove_users": false,
        "promote_users": false,
        "edit_theme_options": false,
        "delete_themes": false,
        "export": false,
        "administrator": false
    },
    "filter": null
}
TESTER;

    public static function logInAdminUser()
    {
        return static::logInUser('admin', 'admin', false);
    }

    public static function createUser(array $roles = ['null'])
    {
        $user = json_decode(static::USER_TEMPLATE);
        $user->roles = $roles;
        return $user;
    }

    public static function setCurrentUser($user): object
    {
        return wp_set_current_user($user);
    }

    public static function logInUser($login = '', $password = '', $remember = false)
    {
        $user = wp_signon([
            'user_login'    => $login,
            'user_password' => $password,
            'remember'      => $remember
        ], false);
        if (is_wp_error($user)) {
            throw new RuntimeException($user->get_error_message());
        }
        return static::setCurrentUser($user);
    }
}
