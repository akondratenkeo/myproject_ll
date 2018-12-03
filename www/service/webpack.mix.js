const mix = require('laravel-mix');

mix.setPublicPath(path.normalize('public/'));

mix.options({
        processCssUrls: false
    });

mix.js('assets/js/app.js', 'public/js')
    .sass('assets/scss/styles.scss', 'public/css');

