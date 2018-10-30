var webpack = require('webpack');
var WebpackNotifierPlugin = require('webpack-notifier');
var path = require('path');

var config = {
    entry: {
        app: './resources/assets/js/bootstrap.js',
    },
    output: {
        path: './public/js',
        publicPath: '/js',
        filename: '[name].js',
    },

    // eval-source-map is faster for development
    // devtool: 'eval-source-map',

    resolve: {
        extensions: ['', '.js', '.vue'],
        alias: {
            'src': './resources/assets/js',
        },
    },

    resolveLoader: {
        root: path.join(__dirname, 'node_modules'),
    },

    module: {
        loaders: [
            {
                test: /\.vue$/,
                loader: 'vue',
            },
            {
                test: /\.js$/,
                loader: 'babel!eslint',
                exclude: /node_modules/,
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'url',
                query: {
                    limit: 10000,
                    name: '[name].[ext]?[hash:7]',
                },
            },
        ],
    },

    vue: {
        loaders: {
            js: 'babel!eslint',
        },
    },

    eslint: {
        formatter: require('eslint-friendly-formatter'),
    },

    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false,
            },
        }),

        // new webpack.optimize.OccurenceOrderPlugin(),

        new WebpackNotifierPlugin({alwaysNotify: true}),
    ],
};

module.exports = config;