var gulp = require('gulp');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');

gulp.task('insertagram-minify-css', function() {
  return gulp.src('./assets/insertagram/css/*.css')
    .pipe(minifyCss())
    .pipe(gulp.dest('./insertagram/css/'));
});

gulp.task('insertagram-minify-js', function() {
  gulp.src('./assets/insertagram/js/*.js')
    .pipe(uglify())
    .pipe(gulp.dest('./insertagram/js/'))
});

gulp.task('insertagram-build', ['insertagram-minify-css', 'insertagram-minify-js']);