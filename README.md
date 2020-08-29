# Rezfusion Hub Components

Provides a shortcode for injecting Rezfusion Components on your WordPress website. Also offers the ability to sync data to your host application to empower advanced marketing and SEO capabilities.

Visit: https://www.bluetent.com/rezfusion-hub/ for more information or to schedule a demo.

## Rezfusion Hub Components Wiki and Documentation

For documentation on Rezfusion Components you can visit the Wiki [here](https://github.com/bluetent/rezfusion-demo-components/wiki).

## Support

Bluetent can not offer free or paid support for individual application installations of the plugin. Bluetent offers support on the JavaScript components only. Usage of this plugin assumes that you've tested the JavaScript components in your own website first, and are ready to add advanced marketing features to your website.

## Use it

Inject the `[rezfusion-component]` shortcode with a `channel` attribute anywhere shortcodes are permitted.

##### Provide a Search UI:

`[rezfusion-component element="some-html-id" channel="https://MY_CHANNEL_URI" guid="MY_GUID"]`

#### Provide a Details Page UI:

`[rezfusion-component element="some-html-id" channel="https://MY_CHANNEL_URI" guid="MY_GUID"]`

You may also choose to render an individual item on the server:

`[rezfusion-lodging-item itemid="TG9kZ2luZ0l0ZW06MTY4NQ=="]`

This will render the template: `vr-details-page.php` found in either the base plugin or by using `locate_template`
to find one in the active theme.

#### Render a component directly in a WordPress template file.

`<?php echo do_shortcode('[rezfusion-component element="details-page"]'); ?>`


