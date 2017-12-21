const AssetsPlugin = require( 'assets-webpack-plugin' );
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' );
const path = require('path');
const webpack = require( 'webpack' );

const extractSass = new ExtractTextPlugin({
    filename: "css/style.min.css",
    disable: process.env.NODE_ENV === "development"
});

const VENDOR_LIBS = [
    'vue'
];

module.exports = function( env = {} ) {
    // function makeStyleLoader(type) {
    //     const cssLoader = {
    //         loader: 'css-loader',
    //         options: {
    //             minimize: env.production
    //         }
    //     };
    //     const loaders = [cssLoader];
    //     if (type)
    //         loaders.push( type + '-loader' );
    //     if (env.production) {
    //         return ExtractTextPlugin.extract( {
    //             use: loaders,
    //             fallback: 'vue-style-loader'
    //         } );
    //     } else {
    //         return [ 'vue-style-loader' ].concat(loaders);
    //     }
    // }
    if (env.production)
        process.env.NODE_ENV = 'production';
    return {
        entry: {
            main: './src/main.js',
            vendor: VENDOR_LIBS
        },
        output: {
            path: path.resolve( __dirname, '../../assets' ),
            filename: env.production ? 'js/[name].min.js?[chunkhash]' : 'js/[name].js',
            publicPath: env.production ? '../' : 'http://www.vue-php.com/'
        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loaders: ['vue-loader']
                },
                {
                    test: /\.scss$/,
                    use: extractSass.extract({
                        use: [{
                            loader: "css-loader"
                        }, {
                            loader: "sass-loader"
                        }],
                        fallback: "style-loader"
                    })
                },
                {
                    test: /\.(png|jpg|gif|svg)$/,
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                name: '[name].[ext]',
                                outputPath: 'images/'
                            }
                        }
                    ]
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /node_modules/
                }
            ]
        },
        plugins: env.production ? [
            extractSass,
            new webpack.DefinePlugin({
                'process.env.NODE_ENV': JSON.stringify('development'),
                'process.env.APP_VERSION': JSON.stringify(process.env.npm_package_version),
            }),
            new webpack.optimize.UglifyJsPlugin( {
                compress: {
                    warnings: false
                }
            } ),
            new AssetsPlugin ({
                filename: 'assets.json',
                path: path.resolve( __dirname, '../../assets' ),
                fullPath: false
            } ),
            new webpack.optimize.CommonsChunkPlugin({
                names: ['vendor', 'manifest']
            }),
        ] : [
            extractSass,
            new webpack.HotModuleReplacementPlugin()
        ],
        resolve: {
            extensions: [ '.js', '.vue', '.json' ],
            alias: {
                '@': path.resolve( __dirname, '..' ),
                vue: 'vue/dist/vue.js'
            }
        },
        devServer: {
            contentBase: false,
            hot: true,
            headers: {
                'Access-Control-Allow-Origin': '*'
            }
        },
        devtool: env.production ? false : '#cheap-module-eval-source-map'
    }
};
