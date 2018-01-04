const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('../public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .autoProvidejQuery()
    .addEntry('js/app', !Encore.isProduction() ? ['./hmr.js', './js/app.js'] : './js/app.js')
    .addStyleEntry('css/app', './css/app.scss')
    .enablePostCssLoader();

// if (Encore.isProduction()) {
//     Encore.setPublicPath('https://my-cool-app.com.global.prod.fastly.net');
//     Encore.setManifestKeyPrefix('build/');
// }

module.exports = Encore.getWebpackConfig();
