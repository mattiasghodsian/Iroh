const mix = require('laravel-mix');

mix.setPublicPath('assets');
mix.setResourceRoot('../');

mix.sass( 'assets/src/scss/app.scss', 'assets/app.css');
mix.js( 'assets/src/js/app.js', 'assets/app.js').autoload({ jquery: ['$', 'window.jQuery'] });

//mix.browserSync('https://mywebsite.test');