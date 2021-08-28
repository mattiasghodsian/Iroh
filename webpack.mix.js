const mix = require('laravel-mix');

/*
|--------------------------------------------------------------------------
| Hot Module Replacement
|--------------------------------------------------------------------------
*/
mix.options({
    hmrOptions: {
        host: '127.0.0.1',
        port: '8081'
    },
});

mix.webpackConfig({
    devServer: {
        port: '8081'
    },
});

/*
|--------------------------------------------------------------------------
| Assets
|--------------------------------------------------------------------------
*/
mix.setPublicPath('assets');
mix.setResourceRoot('../');

mix.sass( 'assets/src/scss/app.scss', 'assets/app.css');
mix.js( 'assets/src/js/app.js', 'assets/app.js').autoload({ jquery: ['$', 'window.jQuery'] });