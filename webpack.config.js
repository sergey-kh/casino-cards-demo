const path = require('path')
const ESLintPlugin = require('eslint-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const TerserPlugin = require('terser-webpack-plugin')
const PostCSSUrl = require('postcss-url')

module.exports = (env, argv) => {
  function isDevelopment () {
    return argv.mode === 'development'
  }

  return {
    entry: {
      'casino-cards-editor': path.resolve(__dirname, 'assets/src/blocks/editor.js'),
      'statistics-card': path.resolve(__dirname, 'assets/src/blocks/statistics-card/front.js'),
      'bonus-card': path.resolve(__dirname, 'assets/src/blocks/bonus-card/front.js'),
    },
    output: {
      path: path.resolve(__dirname, 'assets/dist'),
      filename: 'js/[name].min.js',
      clean: true
    },
    optimization: {
      minimize: argv.mode === 'production',
      minimizer: [
        new TerserPlugin({
          extractComments: false,
          terserOptions: {
            format: {comments: false},
          },
        }),
      ],
    },
    plugins: [
      new MiniCssExtractPlugin({
        chunkFilename: '[id].min.css',
        filename: './css/[name].min.css'
      }),
      new ESLintPlugin({
        extensions: ['js'],
        emitWarning: isDevelopment(),
        failOnError: !isDevelopment()
      })
    ],
    devtool: isDevelopment() ? 'source-map' : false,
    module: {
      rules: [
        {
          test: /\.(sa|sc|c)ss$/,
          use:
            [
              MiniCssExtractPlugin.loader,
              'css-loader',
              {
                loader: 'postcss-loader',
                options: {
                  postcssOptions: {
                    plugins: [
                      [
                        PostCSSUrl,
                        {
                          filter: '**/img/**',
                          url: asset =>
                            asset.url.replace('../../../img/', '../img/')
                        }
                      ],
                      [
                        'postcss-preset-env',
                        {
                          browsers: 'last 2 versions'
                        },
                      ],
                    ],
                  },
                },
              },
              'sass-loader'
            ]
        },
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: [
            {
              loader: 'babel-loader',
              options: {
                presets: [
                  '@babel/preset-env',
                  [
                    '@babel/preset-react',
                    {
                      pragma: 'wp.element.createElement',
                      pragmaFrag: 'wp.element.Fragment',
                      development: isDevelopment()
                    }
                  ]
                ]
              }
            }
          ]
        }
      ],
    },
    externals: {
      react: 'React',
      'react-dom': 'ReactDOM',
      jquery: 'jQuery',
      lodash: 'lodash',
      '@wordpress/blocks': ['wp', 'blocks'],
      '@wordpress/i18n': ['wp', 'i18n'],
      '@wordpress/editor': ['wp', 'editor'],
      '@wordpress/components': ['wp', 'components'],
      '@wordpress/element': ['wp', 'element'],
      '@wordpress/blob': ['wp', 'blob'],
      '@wordpress/data': ['wp', 'data'],
      '@wordpress/html-entities': ['wp', 'htmlEntities'],
      '@wordpress/block-editor': ['wp', 'blockEditor'],
      '@wordpress/api-fetch': ['wp', 'apiFetch']
    }
  }
}