const webpack = require('webpack');
const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer');
const path = require('path');

// const exclude = (modulePath) => /node_modules/.test(modulePath)
// && !/node_modules\/@propertybrands-btt-bluetent-components/.test(modulePath);

module.exports = {
  entry: './assets/js',
  plugins: [
    new webpack.ContextReplacementPlugin(/moment[/\\]locale$/, /en-gb/),
    new BundleAnalyzerPlugin({
      analyzerMode: 'static',
      openAnalyzer: false,
    }),
  ],
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.jsx?$/,
        exclude: /node_modules/,
        loader: 'eslint-loader',
      },
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        loader: 'babel-loader',
        options: {
          presets: [
            '@babel/preset-env',
            '@babel/preset-react',
          ],
          plugins: [
            '@babel/transform-runtime',
            '@babel/plugin-proposal-class-properties',
          ],
        },
      },
      {
        test: /\.tsx?$/,
        loader: 'ts-loader',
        options: { allowTsInNodeModules: true },
      },
      {
        test: /\.css$/i,
        use: ['style-loader', 'css-loader'],
      },
      {
        test: /\.s[ac]ss$/i,
        use: [
          'style-loader',
          'css-loader',
          'sass-loader',
        ],
      },
    ],
  },
  resolve: {
    extensions: ['.js', '.jsx', '.ts', '.tsx'],
    alias: {
      '@propertybrands/btt-bluetent-components': path.resolve(__dirname, 'node_modules/@propertybrands/btt-bluetent-components'),
      '@propertybrands/btt-availability': path.resolve(__dirname, 'node_modules/@propertybrands/btt-availability'),
    },
  },
};
