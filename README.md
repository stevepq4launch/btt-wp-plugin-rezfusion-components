![Version](https://img.shields.io/badge/version-1.0.0-blue.svg?cacheSeconds=2592000) [![semantic-release](https://img.shields.io/badge/%20%20%F0%9F%93%A6%F0%9F%9A%80-semantic--release-e10079.svg)](https://github.com/semantic-release/semantic-release) ![Last update](https://img.shields.io/badge/Last%20update-2021--08--16-yellow)

# Rezfusion Hub Components

Provides a shortcode for injecting Rezfusion Components on your WordPress website. Also offers the ability to sync data to your host application to empower advanced marketing and SEO capabilities.

Visit: https://www.bluetent.com/rezfusion-hub/ for more information or to schedule a demo.

## Rezfusion Hub Components Wiki and Documentation

For documentation on Rezfusion Components you can visit the Wiki [here](https://github.com/bluetent/rezfusion-demo-components/wiki).

## Support

Bluetent can not offer free or paid support for individual application installations of the plugin. Bluetent offers support on the JavaScript components only. Usage of this plugin assumes that you've tested the JavaScript components in your own website first, and are ready to add advanced marketing features to your website.

## Use it

Inject the `[rezfusion-component]` shortcode with a `channel` attribute anywhere shortcodes are permitted.

##### Provide a Search UI: (deprecated)

`[rezfusion-component element="some-html-id" channel="https://MY_CHANNEL_URI" guid="MY_GUID"]`

#### Provide a Details Page UI:

`[rezfusion-component element="some-html-id" channel="https://MY_CHANNEL_URI" guid="MY_GUID"]`

You may also choose to render an individual item on the server:

`[rezfusion-lodging-item itemid="TG9kZ2luZ0l0ZW06MTY4NQ=="]`

This will render the template: `vr-details-page.php` found in either the base plugin or by using `locate_template`
to find one in the active theme.

#### Render a component directly in a WordPress template file.

`<?php echo do_shortcode('[rezfusion-component element="details-page"]'); ?>`

#### Local Development

You can clone this directory down and use `docker-compose up` from the root to start a quick dev/test environment. Uses
all public images, you only need a Docker account to use it.

After running the `up` command you should be able to visit `localhost:8080` and see a WordPress install (or site).

#### Provide a favorite toggle button
`[rezfusion-favorite-toggle itemid="item-id" type="small"]`

Provides a button to toggle an item as favorite on/off.
"type" can be `'large'`, which displays an icon and text or `'small'`, which only displays an icon.

#### Provide a search page
`[rezfusion-search]`

Requires the following Rezfusion plugin settings:
- `rezfusion_hub_folder`

#### Provide a favorites page (deprecated)
`[rezfusion-favorites]`
Requires the setting `settings.favorites.enable` to `true`.

Also requires the following configuration options to be set correctly:
- `settings.components.SearchProvider.channels`
- `settings.components.SearchProvider.endpoint`
- `settings.components.Map.id`
- `settings.components.Map.apiKey`
