import React from 'react';
import ReactDOM from 'react-dom';
import { getConfigOption } from '@propertybrands/btt-bluetent-components/lib/opts';

const element = document.querySelector('.favorite-toggle');
const enableFavorites = getConfigOption(['settings', 'favorites', 'enable']);
if (element && enableFavorites) {
  (async function () {
    const { default: FavoriteToggle } = await import('@propertybrands/btt-bluetent-components/components/Flag/FavoriteFlag');
    const { default: FlaggableProvider } = await import('@propertybrands/btt-bluetent-components/components/Flag/context');
    const { getItems } = await import('@propertybrands/btt-bluetent-components/lib/utils');
    const namespace = getConfigOption(['settings', 'components', 'SearchProvider', 'channels']);
    const id = JSON.parse(element.dataset.rezfusionItemId.toString());
    const itemName = JSON.parse(element.dataset.rezfusionItemName.toString());
    const type = element.dataset.rezfusionToggleType
      ? JSON.parse(element.dataset.rezfusionToggleType.toString())
      : 'small';

    ReactDOM.render((
      <FlaggableProvider
        namespace={namespace}
        defaultState={{
          flagged: {
            [namespace]: getItems(namespace),
          },
        }}
      >
        <FavoriteToggle
          id={id}
          itemName={itemName}
          namespace={namespace}
          type={type}
        />
      </FlaggableProvider>
    ), element);
  }());
}
