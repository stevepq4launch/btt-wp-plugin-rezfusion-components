import React from 'react';
import ReactDOM from 'react-dom';

const el = document.querySelector('.lodging-item-details__photos');
if (el) {
  (async function () {
    const { default: Photos } = await import('@propertybrands/btt-bluetent-components/components/photos/Photos');
    const { default: ConfigProvider } = await import('@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigProvider.tsx');
    const { ThemeProvider } = await import('styled-components');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');
    const { getConfigOption } = await import('@propertybrands/btt-bluetent-components/lib/opts.ts');
    const images = JSON.parse(el.dataset.rezfusionPhotos.toString());
    const itemName = JSON.parse(el.dataset.rezfusionItemName.toString());
    const options = getConfigOption(['settings', 'components', 'DetailsPage', 'options']);

    /**
     * Build out configuration object for our ConfigProvider.
     */
    const config = {
      settings: {
        components: {
          DetailsPage: {
            options,
          },
        },
      },
    };

    /**
     * Pull out our variables, for ease of use.
     */
    const {
      fullScreenImageSize,
      fullScreenShowThumbnail,
    } = options;

    /**
     * Mount/render the actual React component to the DOM.
     */
    ReactDOM.render(
      <ConfigProvider userProvided={config}>
        <ThemeProvider theme={{ ...defaultTheme, ...getConfigOption(['settings', 'theme']) }}>
          <Photos
            imageSize={fullScreenImageSize}
            showThumbnails={fullScreenShowThumbnail}
            unitName={itemName}
            images={images}
            showSingle={false}
          />
        </ThemeProvider>
      </ConfigProvider>, el,
    );
  }());
}
