import React from 'react';
import ReactDOM from 'react-dom';

const el = document.querySelector('#lodging-item-details_categories-display');
if (el) {
  (async function () {
    const { ThemeProvider } = await import('styled-components');
    const { default: ConfigProvider } = await import('@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigProvider.tsx');
    const { default: DetailsProvider } = await import('@propertybrands/btt-bluetent-components/components/DetailsContext/DetailsProvider');
    const { default: CategoriesDisplay } = await import('@propertybrands/btt-bluetent-components/components/DetailsPage/CategoriesDisplay');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');

    const itemId = el.dataset.rezfusionItemId.toString();
    const channels = el.dataset.rezfusionChannel.toString();
    const endpoint = el.dataset.rezfusionEndpoint.toString();
    const confirmationPage = el.dataset.rezfusionConfPage.toString();
    const spsDomain = el.dataset.rezfusionSpsDomain.toString();

    const config = {
      settings: {
        components: {
          SearchProvider: {
            channels,
            endpoint,
          },
          AvailabilitySearchConsumer: {
            spsDomain,
            confirmationPage,
          },
          Checkout: {
            options: {},
          },
        },
      },
    };

    ReactDOM.render((
      <ConfigProvider userProvided={config}>
        <ThemeProvider theme={{ ...defaultTheme }}>
          <DetailsProvider itemId={itemId}>
            <CategoriesDisplay />
          </DetailsProvider>
        </ThemeProvider>
      </ConfigProvider>
    ), el);
  }());
}
