const Encore = require('@symfony/webpack-encore');
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('dashboard', './app/pages/dashboard/app.js')
    .addEntry('products', './app/pages/product/products/app.js')
    .addEntry('productDetails', './app/pages/product/productDetails/app.js')
    .addEntry('productForm', './app/pages/product/productForm/app.js')
    .addEntry('establishments', './app/pages/establishment/establishments/app.js')
    .addEntry('establishmentDetails', './app/pages/establishment/establishmentDetails/app.js')
    .addEntry('establishmentForm', './app/pages/establishment/establishmentForm/app.js')
    .addEntry('menus', './app/pages/menu/menus/app.js')
    .addEntry('menuDetails', './app/pages/menu/menuDetails/app.js')
    .addEntry('menuForm', './app/pages/menu/menuForm/app.js')
    .addEntry('menuComposer', './app/pages/menu/menuComposer/app.js')
    .addEntry('staffMembers', './app/pages/staffMember/staffMembers/app.js')
    .addEntry('staffMemberDetails', './app/pages/staffMember/staffMemberDetails/app.js')
    .addEntry('staffMemberForm', './app/pages/staffMember/staffMemberForm/app.js')
    .addEntry('staffMemberAffectations', './app/pages/staffMember/staffMemberAffectations/app.js')
    .addEntry('mealTimes', './app/pages/mealTime/mealTimes/app.js')
    .addEntry('mealTimeDetails', './app/pages/mealTime/mealTimeDetails/app.js')
    .addEntry('mealTimeForm', './app/pages/mealTime/mealTimeForm/app.js')
    .addEntry('bookings', './app/pages/booking/bookings/app.js')
    .addEntry('bookingDetails', './app/pages/booking/bookingDetails/app.js')
    .addEntry('bookingForm', './app/pages/booking/bookingForm/app.js')

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    //.enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    .enableTypeScriptLoader()

    // uncomment if you use React
    .enableReactPreset()
    
    .enablePostCssLoader()

    .addAliases({
        '@/components': path.resolve(__dirname, 'app/components'),
        '@/lib': path.resolve(__dirname, 'app/lib'),
        '@styles': path.resolve(__dirname, 'app/styles'),
        '@services': path.resolve(__dirname, 'app/services'),
        '@models': path.resolve(__dirname, 'app/types'),
    })


    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
