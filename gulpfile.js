var gulp = require('gulp'),
    concat = require('gulp-concat');

gulp.task('default', ['scripts', 'css'], function() {

});

gulp.task('scripts', function() {
    var src = [
        './bower_modules/jquery/dist/jquery.min.js',
        './bower_modules/trix/dist/trix.js',
        './bower_modules/bootstrap/dist/js/bootstrap.min.js'
    ];

    return gulp.src(src)
        .pipe(concat('all.js'))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('css', function() {
    var src = [
        './bower_modules/trix/dist/trix.css',
        './bower_modules/bootstrap/dist/css/bootstrap.min.css',
        './bower_modules/bootstrap/dist/css/bootstrap-theme.min.css',
        './resources/assets/css/app.css'
    ];

    return gulp.src(src)
        .pipe(concat('all.css'))
        .pipe(gulp.dest('./public/css'));
})