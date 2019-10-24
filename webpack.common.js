var {VueLoaderPlugin} = require('vue-loader');
var HtmlWebpackPlugin = require('html-webpack-plugin');
const path = require('path');

module.exports = {
    entry: {
        // The entry point where Webpack is going to set in the bundle.
        app: './app/index.js'
    },
    module: {
        // Loaders will be applied conversely, the first will be the last to be applied
        rules: [
            {
                test: /\.js?$/, // This is a Regexp it looks to all the files ended with '.js'.
                exclude: /node_modules/, // This is a Regexp as well and points the folders webpack is going to ignore.
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.vue?$/,
                use: 'vue-loader'
            },
            {
                test: /\.(sc|sa|c)ss?$/, // This is a Regexp that matches '.css', 'scss', and 'sass' extensions.
                use: [
                    'vue-style-loader', // 4) Finally injects '<style>' tags into the DOM stemming from '.vue' files.
                    'style-loader', // 3) Injects '<style>' tags into DOM stemming from '.css' files.
                    'css-loader', // 2) Converts a CSS file into a JavaScript code by using 'eval()' without applying the styles.
                    {
                        loader: 'sass-loader', // 1) Converts SASS into CSS code.
                    }
                ]
            },
            {
                test: /\.(png|jpe?g|gif|svg)$/, // This is a Regexp and comprises files with '.png', 'jpg', 'jpeg', 'gif', 'svg'.
                use: [
                    {
                        /*
                         * This loader allows loading pictures from a CSS file (e.g. background-image: url(...)).
                         * IMPORTANT: We need to load this loader before the CSS is loaded otherwise we wouldn't
                         * be able to load pictures.
                         */
                        loader: 'file-loader'
                    }
                ]
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin(),
        new HtmlWebpackPlugin({
            template: './templates/base.html.twig',
            filename: path.resolve(__dirname, 'templates/layouts/app.html.twig')
        })
    ]
}