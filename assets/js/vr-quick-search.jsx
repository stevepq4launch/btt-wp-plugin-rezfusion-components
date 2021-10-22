import React from 'react';
import ReactDOM from 'react-dom';

const element = document.getElementById('rezfusion-quicksearch');
if (element) {
  (async () => {
    const { default: QuickSearch } = await import('@propertybrands/btt-bluetent-components/components/QuickSearch/QuickSearch');
    const { getConfigOption } = await import('@propertybrands/btt-bluetent-components/lib/opts.ts');
    const { default: ComponentWrapper } = await import('./component-wrapper');
    ReactDOM.render((
      <ComponentWrapper
        searchProviderCallback={({ component }) => {
          component.getCategoryInfo();
        }}
      >
        <QuickSearch
          searchPath={getConfigOption(['settings', 'components', 'QuickSearch', 'searchPath'])}
          domNode={element}
        />
      </ComponentWrapper>
    ), element);
  })();
}
