const { mix } = require('laravel-mix');

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


//original
/*
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
*/

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .scripts([
      '../vendor/jquery/dist/jquery.js',
	  '../vendor/dropzone/dist/dropzone.js',
      'app.js'
    ], 'public/js/app.js')
	.styles([
	'../vendor/dropzone/dist/dropzone.css',
	],'public/css/app.css')
	.version()
	.copy("resources/assets/vendor/font-awesome/fonts", "public/build/fonts");



/*
var elixir = require('laravel-elixir');

elixir(function (mix) {
  mix
    .sass('app.scss')
    .scripts([
      '../vendor/jquery/dist/jquery.js',
      '../vendor/bootstrap-sass/assets/javascripts/bootstrap.js',
      'app.js'
    ], 'public/js/app.js')
    .version([
      'css/app.css',
      'js/app.js'
    ])
    .copy("resources/assets/vendor/font-awesome/fonts", "public/build/fonts");
});
*/
