const mix = require('laravel-mix');
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

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.scss/,
                loader: 'import-glob-loader'
            }
        ]
    }
});

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
    .browserSync({
        proxy: 'vue-dash.kevin'
    })
    .version()

    // sassVariables.forEach(filename => {
    //     console.log(filename);
    //     mix.sass(filename, 'public/css');
    // });
    //
    // sassFiles.forEach(filename => {
    //     console.log(filename);
    //     mix.sass(filename, 'public/css');
    // });