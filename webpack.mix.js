const mix = require('laravel-mix');

mix.setPublicPath('assets');
mix.setResourceRoot('../');

mix.combine( 'assets/src/js/*.js', 'assets/app.js');
mix.sass( 'assets/src/scss/app.scss', 'assets/app.css');

//mix.browserSync('https://mywebsite.test');