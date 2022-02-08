const path = require('path');
const enabledSourceMap = process.env.NODE_ENV === 'development';

/**
 * valiables of pluguin
 */
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');

const webpackConfig = {
  context: path.resolve(__dirname, 'src'),

  entry: path.join(__dirname, '/src', '/js', 'main.js'),

  output: {
    path: path.join(__dirname, '/dist'),
    filename: 'js/[name].bundle.js',
    publicPath: 'auto',
  },

  devServer: {
    static: {
      directory: path.join(__dirname, 'dist'),
    },
    open: {
      app: {
        name: 'Google Chrome',
      },
    },
    port: 9999,
    hot: true,
    watchFiles: ['src/index.php'],
  },

  watchOptions: {
    ignored: ['**/node_modules'],
  },

  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
          {
            loader: 'babel-loader',
            options: {
              presets: [
                [
                  '@babel/preset-env',
                  {
                    targets: [
                      'last 1 version',
                      '> 1%',
                      'maintained node versions',
                      'not dead',
                    ],
                    useBuiltIns: 'usage',
                    corejs: 3,
                  },
                ],
              ],
            },
          },
        ],
      },

      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },

          {
            loader: 'css-loader',
            options: {
              url: true,
              sourceMap: enabledSourceMap,
              importLoaders: 2,
            },
          },

          {
            loader: 'postcss-loader',
            options: {
              sourceMap: enabledSourceMap,
              postcssOptions: {
                plugins: [['autoprefixer', { grid: true }]],
              },
            },
          },

          {
            loader: 'sass-loader',
            options: {
              sourceMap: enabledSourceMap,
            },
          },
        ],
      },
    ],
  },

  // Plugins
  plugins: [
    new CleanWebpackPlugin(),

    // Specify how to output the extracted CSS
    new MiniCssExtractPlugin({
      filename: 'css/style.css',
    }),

    // Specify which folder to copy from and to which folder
    new CopyPlugin({
      patterns: [
        {
          from: `${__dirname}/src/index.php`,
          to: `${__dirname}/dist/index.php`,
        },
        {
          from: `${__dirname}/src/.htaccess`,
          to: `${__dirname}/dist/.htaccess`,
          toType: "file",
        },
        {
          from: `${__dirname}/src/php/`,
          to: `${__dirname}/dist/php/`,
        },
        {
          from: `${__dirname}/src/images/`,
          to: `${__dirname}/dist/images/`,
        },
      ],
    }),
  ],

  optimization: {
    minimize: true,
    minimizer: [
      new TerserPlugin({
        extractComments: false,
        terserOptions: {
          compress: {
            drop_console: true,
          },
        },
      }),
      new CssMinimizerPlugin({
        minimizerOptions: {
          preset: [
            'default',
            {
              discardComments: { removeAll: true },
            },
          ],
        },
      }),
    ],
  },

  cache: {
    type: 'filesystem',
    allowCollectingMemory: true,
    buildDependencies: {
      config: [__filename],
    },
  },
};

// Apply
module.exports = webpackConfig;
