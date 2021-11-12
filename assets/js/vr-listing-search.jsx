import React from 'react';
import ReactDOM from 'react-dom';

const mainApp = document.getElementById('app');
if (mainApp) {
  (async function () {
    const { ThemeProvider } = await import('styled-components');
    const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');
    const { getConfigOption } = await import('@propertybrands/btt-bluetent-components/lib/opts.ts');
    const { getItems } = await import('@propertybrands/btt-bluetent-components/lib/utils.ts');
    const { default: ConfigProvider } = await import('@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigProvider.tsx');
    const { default: FlaggableProvider } = await import('@propertybrands/btt-bluetent-components/components/Flag/context');
    const { default: Modal } = await import('react-modal');
    const { default: SearchPage } = await import('@propertybrands/btt-bluetent-components/components/Search/Search');
    Modal.setAppElement('#app');
    const enableFavorites = getConfigOption(['settings', 'favorites', 'enable']);
    const showRatingFilter = getConfigOption(['settings', 'components', 'SearchPage', 'showRatingFilter']);
    const unitMapSplitView = getConfigOption(['settings', 'components', 'SearchPage', 'unitMapSplitView']);
    const hideFilters = getConfigOption(['settings', 'components', 'SearchPage', 'hideFilters']);
    const showExactRangeToggles = getConfigOption(['settings', 'components', 'SearchProvider', 'showExactRangeToggles']);
    const channels = getConfigOption(['settings', 'components', 'SearchProvider', 'channels']);
    const currentlyFlaggedItems = getItems(channels);
    const config = {
      settings: {
        favorites: {
          enable: enableFavorites,
        },
        components: {
          SearchProvider: {
            channels,
            showExactRangeToggles,
          },
          SearchPage: {
            showRatingFilter,
            unitMapSplitView,
            hideFilters,
          },
        },
      },
    };
    ReactDOM.render((
      <ConfigProvider userProvided={config}>
        <ThemeProvider theme={{ ...defaultTheme, ...getConfigOption(['settings', 'theme']) }}>
          <FlaggableProvider
            namespace={channels}
            defaultState={{
              flagged: {
                [channels]: currentlyFlaggedItems,
              },
            }}
          >
            <SearchPage
              showRatingFilter={showRatingFilter}
              unitMapSplitView={unitMapSplitView}
              hideFilters={hideFilters}
              showExactRangeToggles={showExactRangeToggles}
              enableFavorites={enableFavorites}
              favoritesNamespace={channels}
              appTheme={getConfigOption(['settings', 'theme'])}
            />
          </FlaggableProvider>
        </ThemeProvider>
      </ConfigProvider>
    ), mainApp);
  }());
}
