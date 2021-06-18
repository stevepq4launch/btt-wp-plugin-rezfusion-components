import React from 'react';
import ReactDOM from 'react-dom';

const el = document.querySelector('.lodging-item-details__photos');
if (el) {
  (async function () {
    const { default: Photos } = await import('@propertybrands/btt-bluetent-components/components/photos');
    const { ThemeProvider } = await import('styled-components');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');
    const { getConfigOption } = await import('@propertybrands/btt-bluetent-components/lib/opts');
    const images = JSON.parse(el.dataset.rezfusionPhotos.toString());
    const itemName = JSON.parse(el.dataset.rezfusionItemName.toString());
    ReactDOM.render(
      <ThemeProvider theme={{ ...defaultTheme, ...getConfigOption(['settings', 'theme']) }}>
        <Photos imageSize={-1} unitName={itemName} images={images} />
      </ThemeProvider>, el,
    );
  }());
}
