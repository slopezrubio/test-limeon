const path = require('path');
const common = require('./webpack.common');
const merge = require('webpack-merge');

module.exports = (common, {
    mode: 'production', // Minifies the JavaScript and the CSS bundled.
    output: {
        // Path of the bundled file.
        path: path.resolve(__dirname, 'public/bundles/js/'),

        /*
         * Name of the file bundled encoded with MD5 Hash. This name is going to
         * be modified whenever a change is made inside the file so that the browser
         * can cache the file if it wasn't modified or can loaded again if the opposite
         * is the case.
         */
        filename: '[name].[contentHash].bundle.js'
    }
});