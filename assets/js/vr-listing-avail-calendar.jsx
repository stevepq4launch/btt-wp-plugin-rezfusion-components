import React from 'react';
import ReactDOM from 'react-dom';

const el = document.querySelector('.lodging-item-details__avail-calendar');

if (el) {
  (async function () {
    const { ThemeProvider } = await import('styled-components');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');
    const { getConfigOption } = await import('@propertybrands/btt-bluetent-components/lib/opts.ts');
    const { wrapDates } = await import('@propertybrands/btt-availability');
    const { default: AvailabilityPicker } = await import('@propertybrands/btt-bluetent-components/components/AvailabilityPicker/AvailabilityPicker');
    const avail = JSON.parse(el.dataset.rezfusionAvailability.toString());
    const restrictions = JSON.parse(el.dataset.rezfusionRestrictions.toString());
    const prices = JSON.parse(el.dataset.rezfusionPrices.toString());
    ReactDOM.render(
      <ThemeProvider theme={{ ...defaultTheme, ...getConfigOption(['settings', 'theme']) }}>
        <AvailabilityPicker
          type="DayPickerRangeController"
          numberOfMonths={2}
          options={{
            avail: avail.map((avbk) => wrapDates(avbk)),
            restrictions: restrictions.map((rst) => wrapDates(rst)),
            prices: prices.map((pr) => wrapDates(pr)),
            requirePrices: true,
            showNightlyPrices: true,
          }}
        />
      </ThemeProvider>, el,
    );
  }());
}
