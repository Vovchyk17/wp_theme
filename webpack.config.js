/*
1. update theme name in package.json
2. run in terminal: npm i
3. run in terminal: npm run dev - for development
4. run in terminal: npm run build - for production
5. edit assets.php
*/

const glob = require('glob');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

// Get all .scss files from the style directory and its subdirectories
const scssFiles = glob.sync('./style/**/*.scss');

const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
    entry: {
        'main': [
            './js/libs/common-libs.js',
            './js/scripts.js',
            ...(isProduction ? ['./style/fonts.css', './style/style.css'] : [])
        ],
        'ajax': './js/ajax.js',
    },
    output: {
        filename: 'dist/[name].min.js',
        path: path.resolve(__dirname),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: 'babel-loader'
            },
            {
                test: /\.(css|scss)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'sass-loader',
                        options: {
                            sassOptions: {
                                includePaths: ['./style', './style/templates']
                            },
                        },
                    },
                ],
            },
            {
                test: /\.(svg|png|jpg|jpeg|gif)$/,
                type: 'asset/resource',
                generator: {
                    filename: './images/[name][ext]',
                }
            },
            {
                test: /\.(woff(2)?|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
                type: 'asset/resource',
                generator: {
                    filename: './fonts/[name][ext]',
                }
            }
        ]
    },
    optimization: {
        minimize: true,
        minimizer: [
            new CssMinimizerPlugin(),
            new TerserPlugin(),
        ]
    },
    plugins: [
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: ['dist/**/*'],
        }),
        new MiniCssExtractPlugin({
            filename: 'dist/[name].min.css'
        }),
        new BrowserSyncPlugin({
            proxy: 'http://wp-theme.local/',
            files: ['**/*.php', '**/*.scss', '**/*.js'],
            notify: false,
            reloadDelay: 0
        })
    ],
    devServer: {
        static: {
            directory: path.join(__dirname),
            watch: true,
        },
        hot: false,
    }
};
