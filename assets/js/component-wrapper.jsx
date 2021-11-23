import React from 'react';
import PropTypes from 'prop-types';
import { ThemeProvider } from 'styled-components';
import { defaultTheme } from '@propertybrands/btt-bluetent-components/lib/styles';
import { getConfigOption } from '@propertybrands/btt-bluetent-components/lib/opts.ts';
import { SearchProvider } from '@propertybrands/btt-bluetent-components/components/SearchProvider/index.tsx';
import ConfigProvider from '@propertybrands/btt-bluetent-components/components/ConfigContext/ConfigProvider.tsx';

/**
 * Provides a way for wrapping component in common contexts.
 * @param {node} children
 * @param {ConfigInterface} userProviderConfig,
 * @param {function|null|undefined} searchProviderCallback
 * @returns {JSX.Element}
 * @constructor
 */
const ComponentWrapper = ({
  children,
  userProviderConfig,
  searchProviderCallback,
}) => (
  <ConfigProvider userProvided={userProviderConfig}>
    <ThemeProvider theme={{ ...defaultTheme, ...getConfigOption(['settings', 'theme']) }}>
      <SearchProvider
        channels={getConfigOption(['settings', 'components', 'SearchProvider', 'channels'])}
        endpoint={getConfigOption(['settings', 'components', 'SearchProvider', 'endpoint'])}
        query=""
        mountCallback={(component) => {
          if (typeof searchProviderCallback === 'function') {
            searchProviderCallback({ component });
          }
        }}
      >
        {children}
      </SearchProvider>
    </ThemeProvider>
  </ConfigProvider>
);

ComponentWrapper.propTypes = {
  children: PropTypes.node.isRequired,
  userProviderConfig: undefined,
  searchProviderCallback: PropTypes.func,
};

ComponentWrapper.defaultProps = {
  userProviderConfig: {},
  searchProviderCallback: null,
};

export { ComponentWrapper as default };
