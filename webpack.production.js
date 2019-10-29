const merge = require('webpack-merge');
const common = require('./webpack.common');
const path = require('path');

module.exports = merge(common, {
    mode: 'production', // Minifies the JavaScript and the CSS bundled.
    output: {
        // Path of the bundled file.
        path: path.resolve(__dirname, 'public/'),

        publicPath: './',

        /*
         * Name of the file bundled encoded with MD5 Hash. This name is going to
         * be modified whenever a change is made inside the file so that the browser
         * can cache the file if it wasn't modified or can loaded again if the opposite
         * is the case.
         */
        filename: 'bundles/js/[name].[contentHash].bundle.js'
    }
});