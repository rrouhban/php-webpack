const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const webpack = require('webpack');
const autoprefixer = require('autoprefixer');

module.exports = {
    entry: {
        main: './src/main.js',
    },
    output: {
        path: path.resolve(__dirname, 'assets'),
        filename: 'js/[name].js',
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    scss: 'style!css!sass',
                },
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.s[a|c]ss$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        'css-loader',
                        'sass-loader',
                    ],
                }),
            },
            {
                test: /\.(jpg|png|svg)$/,
                loader: 'file-loader',
            },
        ],
    },
    plugins: [
        new ExtractTextPlugin({
            filename: 'css/style.css',
        }),
        new webpack.LoaderOptionsPlugin({
            options: { sassLoader: { includePaths: [path.resolve(__dirname, 'node_modules')] } },
        }),
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: `'${process.env.NODE_ENV}'`,
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.js'
        }
    }
};
