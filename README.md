# Rezfusion Components

Provides a shortcode for injecting Rezfusion Components on your WordPress website.

## Use it

Inject the `[rezfusion-component]` shortcode with a `channel` attribute anywhere shortcodes are permitted.

### Provide a Search UI:

`[rezfusion-component element="some-html-id" channel="https://MY_CHANNEL_URI"]`

### Provide a Details Page UI:

`[rezfusion-component element="some-html-id" channel="https://MY_CHANNEL_URI" source="details.js"]`