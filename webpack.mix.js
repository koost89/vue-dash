const mix = require('laravel-mix');
const glob = require('glob');

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

let sassVariables = glob.sync('resources/sass/variables/*.scss');
let sassFiles = glob.sync('resources/sass/*.scss');
mix.js('resources/js/app.js', 'public/js')
   // .sass(sassVariables, 'public/css')
   // .sass(sassFiles, 'public/css')
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