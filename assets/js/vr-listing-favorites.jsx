import React from 'react';
import ReactDOM from 'react-dom';
import Modal from 'react-modal';
import { getConfigOption } from '@propertybrands/btt-bluetent-components/lib/opts';

const favoritesPage = document.getElementById('favorites-page');
if (favoritesPage) {
  const enableFavorites = getConfigOption(['settings', 'favorites', 'enable']);
  if (enableFavorites) {
    const namespace = getConfigOption(['settings', 'components', 'SearchProvider', 'channels']);
    Modal.setAppElement('#favorites-page');
    (async function () {
      const { ThemeProvider } = await import('styled-components');
      const { getItems } = await import('@propertybrands/btt-bluetent-components/lib/utils');
      const { defaultTheme } = await import('@propertybrands/btt-bluetent-components/lib/styles');
      const { default: FlaggableProvider } = await import('@propertybrands/btt-bluetent-components/components/Flag/context');
      const { default: FavoritesPage } = await import('@propertybrands/btt-bluetent-components/components/Search/FavoritesPage');
      const currentlyFlaggedItems = getItems(namespace);
      const {
        showRatingFilter,
        showReviewsSummary,
        unitMapSplitView,
        hideFilters,
      } = getConfigOption(['settings', 'components', 'SearchPage']);
      ReactDOM.render((
        <ThemeProvider theme={{ ...defaultTheme, ...getConfigOption(['settings', 'theme']) }}>
          <FlaggableProvider
            namespace={namespace}
            defaultState={{
              flagged: {
                [namespace]: currentlyFlaggedItems,
              },
            }}
          >
            <FavoritesPage
              showRatingFilter={showRatingFilter}
              showReviewsSummary={showReviewsSummary}
              unitMapSplitView={unitMapSplitView}
              hideFilters={hideFilters}
              enableFavorites={enableFavorites}
              favoritesNamespace={namespace}
              appTheme={getConfigOption(['settings', 'theme'])}
            />
          </FlaggableProvider>
        </ThemeProvider>
      ), favoritesPage);
    }());
  }
}
