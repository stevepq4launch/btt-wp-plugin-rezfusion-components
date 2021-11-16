import React from 'react';
import ReactDOM from 'react-dom';

const el = document.querySelector('#lodging-item-details_categories-display');
if (el) {
  (async function () {
    const { ThemeProvider } = await import('styled-components');
    const { default: ConfigProvider } = await import('@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigProvider');
    const { default: DetailsProvider } = await import('@propertybrands/btt-bluetent-components/components/DetailsContext/DetailsProvider');
    const { default: CategoriesDisplay } = await import('@propertybrands/btt-bluetent-components/components/DetailsPage/CategoriesDisplay');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');

    const itemId = el.dataset.rezfusionItemId.toString();
    const config = {
      settings: {
        components: {
          SearchProvider: {
            channels: 'https://easternshorevacations.com',
            endpoint: 'http://host.docker.internal:3000/graphql',
          },
          AvailabilitySearchConsumer: {
            spsDomain: 'https://checkout.rezfusion.com',
            confirmationPageL: '',
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
