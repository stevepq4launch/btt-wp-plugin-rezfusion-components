import React from 'react';
import ReactDOM from 'react-dom';

const el = document.querySelector('#lodging-item-details_categories-display');
if (el) {
  (async function () {
    const { ThemeProvider } = await import('styled-components');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');
    const { getConfigOption } = await import('@propertybrands/btt-bluetent-components/lib/opts');
    const { default: ConfigProvider } = await import('@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigProvider');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');
    const { getConfigOption } = await import('@propertybrands/btt-bluetent-components/lib/opts');
    const images = JSON.parse(el.dataset.rezfusionPhotos.toString());
    const itemName = JSON.parse(el.dataset.rezfusionItemName.toString());
    ReactDOM.render(
      <ConfigProvider>
        <ThemeProvider>
          <DetailsProvider>
            <h1>Hello world!</h1>
          </DetailsProvider>
        </ThemeProvider>
      </ConfigProvider>, el
    );
  }());
}
