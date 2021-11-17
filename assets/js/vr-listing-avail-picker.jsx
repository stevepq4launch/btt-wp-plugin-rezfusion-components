import React from 'react';
import ReactDOM from 'react-dom';

const el = document.querySelector('.lodging-item-details__avail-picker');

if (el) {
  (async function () {
    const { ThemeProvider } = await import('styled-components');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');
    const { getConfigOption } = await import('@propertybrands/btt-bluetent-components/lib/opts.ts');
    const { wrapDates } = await import('@propertybrands/btt-availability');
    const { default: ConfigProvider } = await import('@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigProvider.tsx');
    const { default: DetailsProvider } = await import('@propertybrands/btt-bluetent-components/components/DetailsContext/DetailsProvider');
    const { default: SearchForms } = await import('@propertybrands/btt-bluetent-components/components/DetailsPage/SearchForms');
    const { default: QuoteProvider } = await import('@propertybrands/btt-bluetent-components/components/QuoteContext/QuoteProvider');

    const appTheme = getConfigOption(['settings', 'theme']);
    const dateWrapper = (dates) => dates.map((dateBlock) => wrapDates(dateBlock));
    const avail = dateWrapper(JSON.parse(el.dataset.rezfusionAvailability.toString()));
    const restrictions = dateWrapper(JSON.parse(el.dataset.rezfusionRestrictions.toString()));
    const prices = dateWrapper(JSON.parse(el.dataset.rezfusionPrices.toString()));
    const itemId = el.dataset.rezfusionItemId.toString();
    const itemPmsId = el.dataset.rezfusionItemPmsId.toString();
    const channels = el.dataset.rezfusionChannel.toString();
    const endpoint = el.dataset.rezfusionEndpoint.toString();
    const confirmationPage = el.dataset.rezfusionConfPage.toString();
    const spsDomain = el.dataset.rezfusionSpsDomain.toString();
    const type = parseInt(el.dataset.rezfusionItemType, 10);

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

    ReactDOM.render(
      (
        <ConfigProvider userProvided={config}>
          <ThemeProvider theme={{ ...defaultTheme, ...appTheme }}>
            <DetailsProvider itemId={itemId}>
              <QuoteProvider
                itemId={itemId}
                type={type}
              >
                <SearchForms
                  anchorDirection="right"
                  availOptions={{ avail, restrictions, prices }}
                  remoteId={itemPmsId}
                />
              </QuoteProvider>
            </DetailsProvider>
          </ThemeProvider>
        </ConfigProvider>
      ),
      el,
    );
  }());
}
