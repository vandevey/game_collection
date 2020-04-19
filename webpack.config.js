var Encore = require('@symfony/webpack-encore');

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
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    .copyFiles({
        from: './assets/images',
        //if versioning is enabled, add the file hash too
        to: 'images/[path][name].[ext]',
        // only copy files matching this pattern
        pattern: /\.(png|jpg|jpeg)$/
    })

    .addEntry('js/app', './assets/js/app.js')
    .addEntry('css/app', './assets/scss/app.scss')
    .cleanupOutputBeforeBuild()

    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)

    // enables Sass/SCSS support
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
