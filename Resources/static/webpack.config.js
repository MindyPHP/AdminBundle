const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('../public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableSassLoader()
    .autoProvidejQuery()
    .addEntry('js/app', !Encore.isProduction() ? ['./hmr.js', './js/app.js'] : './js/app.js')
    .addStyleEntry('css/app', './css/app.scss')
    .enablePostCssLoader();

if (Encore.isProduction()) {
    Encore.setPublicPath('/bundles/admin/build');
    Encore.setManifestKeyPrefix('bundles/admin/build/');
}

module.exports = Encore.getWebpackConfig();
