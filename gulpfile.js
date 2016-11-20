const elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.browserify("app.js")

    mix.sass("app.scss");

    mix.scripts([
        "./bower_modules/jquery/dist/jquery.min.js",
        "./bower_modules/bootstrap/dist/js/bootstrap.min.js",
        "./public/js/app.js"
    ]);

    mix.version(['css/app.css'])
});