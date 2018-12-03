const mix = require('laravel-mix');

mix.setPublicPath(path.normalize('public/'));

mix.options({
        processCssUrls: false
    });

/* Build configuration for user's section. */
mix.js('assets/admin/js/app.js', 'public/admin/js')
    .sass('assets/admin/scss/styles.scss', 'public/admin/css')
    .copyDirectory('assets/admin/images', 'public/admin/images')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/admin/fonts');


/* Build configuration for user's section. */
mix.js('assets/frontend/js/app.js', 'public/js')
    .sass('assets/frontend/scss/styles.scss', 'public/css')
    .copyDirectory('assets/frontend/images', 'public/images')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts');

