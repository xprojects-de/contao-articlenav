const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('src/Resources/public/')
    .setPublicPath('/bundles/articlenav')
    .setManifestKeyPrefix('')
    .cleanupOutputBeforeBuild()
    .disableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .addEntry('articlenav', './assets/articlenav.js')
;

module.exports = [Encore.getWebpackConfig()];