var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/bundles/')
    .setManifestKeyPrefix('bundles')
    .setPublicPath('/bundles')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './app/index.js')
    .addStyleEntry('main', './app/scss/main.scss')

    /* Will require an extra script tag for runtime.js included in your page
     * but, you probably want this, unless you're building a single-page app
     */
    .enableSingleRuntimeChunk()
    //.disableSingleRuntimeChunk()

    // Enables hashed filenames (e.g. app.439flkj94.js) when production mode
    .enableVersioning(Encore.isProduction())

    // Enables @babel/preset-env polyfills
    // Use this if there is not a .babelrc file in your root directory
    /*.configureBabel(null, {
        useBuiltIns: 'usage',
        corejs: 3,
    })*/

    // Enables Sass/SCSS support
    .enableSassLoader()

    // Enables Vue.js support
    .enableVueLoader()

    // Allow to see which file JavaScript errors and logs come from.
    .enableSourceMaps(!Encore.isProduction())
;

const config = Encore.getWebpackConfig();

config.name = 'main';

module.exports = config;