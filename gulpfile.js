const elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass("app.scss");

    mix.scripts([
        "./bower_modules/jquery/dist/jquery.min.js",
        "./bower_modules/bootstrap/dist/js/bootstrap.min.js"
    ]);
});