var gulp = require('gulp');
var minifyCss = require('gulp-minify-css');
var minify = require('gulp-minify');

gulp.task('insertagram-minify-css', function() {
  return gulp.src('./assets/insertagram/css/*.css')
    .pipe(minifyCss())
    .pipe(gulp.dest('./insertagram/css/'));
});

gulp.task('insertagram-minify-js', function() {
  gulp.src('./assets/insertagram/js/*.js')
    .pipe(minify())
    .pipe(gulp.dest('./insertagram/js/'))
});

// default
//gulp.task('default', ['mongodump', 'mongorestore']);

// one
//gulp.task('one', ['concatRequire', 'minifyCss']);