const mix = require('laravel-mix');

mix.setPublicPath(path.normalize('public/'));

mix.sourceMaps()
    .options({
        processCssUrls: false
    });

/* Build configuration for user's section. */
mix.js('assets/js/app.js', 'public/js')
    .sass('assets/scss/styles.scss', 'public/css')
    .copyDirectory('assets/images', 'public/images');

