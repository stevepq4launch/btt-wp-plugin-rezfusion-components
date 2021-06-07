import React from 'react';
import PropTypes from 'prop-types';
import { SearchProvider } from '@propertybrands/btt-bluetent-components/components/SearchProvider';
import { getConfigOption } from '@propertybrands/btt-bluetent-components/lib/opts';

/**
 *
 * @param channels
 * @param endpoint
 * @param children
 * @param query
 * @returns {JSX.Element}
 * @constructor
 */
const ContextProvider = ({
  channels,
  endpoint,
  children,
  query,
}) => (
  <SearchProvider
    channels={channels}
    endpoint={endpoint}
    query={query}
    filters={getConfigOption(['settings', 'components', 'SearchProvider', 'filters'])}
    mountCallback={(component) => {
      const { filters } = component.state;
      const { availFilter } = filters;
      if (availFilter.begin && availFilter.end) {
        component.search(filters);
      }
    }}
  >
    {children}
  </SearchProvider>
);

ContextProvider.propTypes = {
  channels: PropTypes.string.isRequired,
  endpoint: PropTypes.string.isRequired,
  children: PropTypes.node.isRequired,
  query: PropTypes.string.isRequired,
};

export { ContextProvider as default };
