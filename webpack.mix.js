const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js/')
    .js('resources/js/diagram.js', 'public/js/');

mix.sass('resources/sass/app.scss', 'public/css/')
    .sass('resources/sass/form.scss', 'public/css/')
    .sass('resources/sass/modal.scss', 'public/css/')
    .sass('resources/sass/menu.scss', 'public/css/')
    .sass('resources/sass/diagram.scss', 'public/css/')
    .sass('resources/sass/schedule.scss', 'public/css/')
    .sass('resources/sass/vertical-list.scss', 'public/css/');