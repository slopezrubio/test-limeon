const merge = require('webpack-merge');
const common = require('./webpack.common');
const path = require('path');

/**
 * The 'merge()' method grabs the 'webpack.common.js' and merges
 * into this Webpack configuration.
 */
module.exports = merge(common, {
    mode: 'development',
    output: {
        // Path of the bundled file.
        path: path.resolve(__dirname, 'public/'),

        publicPath: '/',

        // Name of the file bundled.
        filename: 'bundles/js/bundle.js'
    }
});