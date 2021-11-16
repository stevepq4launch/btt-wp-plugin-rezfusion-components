import React from 'react';
import ReactDOM from 'react-dom';

const el = document.querySelector('#lodging-item-details_categories-display');
if (el) {
  (async function () {
    const { ThemeProvider } = await import('styled-components');
    const { default: ConfigProvider } = await import('@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigProvider');
    const { default: DetailsProvider } = await import('@propertybrands/btt-bluetent-components/components/DetailsContext/DetailsProvider');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');

    const itemId = 'SXRlbTo5Nzc1';
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
            <h1>Hello world!</h1>
          </DetailsProvider>
        </ThemeProvider>
      </ConfigProvider>
    ), el);
  }());
}
