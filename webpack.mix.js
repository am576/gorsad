const mix = require('laravel-mix');

/*require('laravel-mix-bundle-analyzer');
if (!mix.inProduction()) {
    mix.bundleAnalyzer();
} */// --- Uncomment for bundle analyze


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .js('resources/js/shop.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/home-page.scss', 'public/css')
    .sass('resources/sass/services.scss', 'public/css')
    .sass('resources/sass/static_page.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')
    .sass('resources/sass/projects.scss', 'public/css')
    .sass('resources/sass/guide_page.scss', 'public/css')
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve('resources/sass')
            }
        }
    })
