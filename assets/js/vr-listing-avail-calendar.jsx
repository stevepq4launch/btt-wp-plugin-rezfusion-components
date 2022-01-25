import React, { useState, useContext } from 'react';
import ReactDOM from 'react-dom';

const el = document.querySelector('.lodging-item-details__avail-calendar');

if (el) {
  (async function () {
    const { ThemeProvider } = await import('styled-components');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');
    const { default: ConfigProvider } = await import('@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigProvider.tsx');
    const { default: ConfigContext } = await import('@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigContext.ts');
    const { default: DetailsProvider } = await import('@propertybrands/btt-bluetent-components/components/DetailsContext/DetailsProvider');
    const { getConfigOption } = await import('@propertybrands/btt-bluetent-components/lib/opts.ts');
    const { wrapDates } = await import('@propertybrands/btt-availability');
    const { default: AvailabilityPicker } = await import('@propertybrands/btt-bluetent-components/components/AvailabilityPicker/AvailabilityPicker');

    const dateWrapper = (dates) => dates.map((dateBlock) => wrapDates(dateBlock));

    const appTheme = getConfigOption(['settings', 'theme']);
    const channels = el.dataset.rezfusionChannel.toString();
    const endpoint = el.dataset.rezfusionEndpoint.toString();
    const confirmationPage = el.dataset.rezfusionConfPage.toString();
    const spsDomain = el.dataset.rezfusionSpsDomain.toString();
    const avail = dateWrapper(JSON.parse(el.dataset.rezfusionAvailability.toString()));
    const restrictions = dateWrapper(JSON.parse(el.dataset.rezfusionRestrictions.toString()));
    const prices = dateWrapper(JSON.parse(el.dataset.rezfusionPrices.toString()));
    const itemId = el.dataset.rezfusionItemId.toString();
    const singleCalendar = window.innerWidth < 1100;
    // const itemPmsId = el.dataset.rezfusionItemPmsId.toString();
    // const type = parseInt(el.dataset.rezfusionItemType, 10);

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

    const PickerWrapper = () => {
      const [dates, setDates] = useState({ begin: null, end: null });
      const configContext = useContext(ConfigContext);
      if (!configContext) {
        return null;
      }
      const {
        settings: {
          components: {
            AvailabilitySearchConsumer: {
              options: {
                requirePrices,
                showNightlyPrices,
                dateFormat,
                minStay,
                maxStay,
                increment,
                turnDays,
                datedTurnDays,
                minAdvance,
                maxAdvance,
                showUnavailablePrices,
              },
            },
          },
        },
      } = configContext;

      const handleDatesChange = (begin, end) => {
        setDates({ begin, end });
      };

      return (
        <AvailabilityPicker
          rcav={{ begin: dates.begin, end: dates.end }}
          type="DayPickerRangeController"
          numberOfMonths={singleCalendar ? 1 : 2}
          options={{
            avail,
            restrictions,
            prices,
            requirePrices,
            showNightlyPrices,
            dateFormat,
            minStay,
            maxStay,
            increment,
            turnDays,
            datedTurnDays,
            minAdvance,
            maxAdvance,
            showUnavailablePrices,
          }}
          handleDatesChange={handleDatesChange}
          isSingleListing
        />
      );
    };

    ReactDOM.render(
      <ConfigProvider userProvided={config}>
        <ThemeProvider theme={{ ...defaultTheme, ...appTheme }}>
          <DetailsProvider itemId={itemId}>
            <PickerWrapper />
          </DetailsProvider>
        </ThemeProvider>
      </ConfigProvider>, el,
    );
  }());
}
