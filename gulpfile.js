var gulp = require('gulp');
var minifyCss = require('gulp-minify-css');

gulp.task('insertagram-minify-css', function() {
  return gulp.src('./assets/insertagram/css/*.css')
    .pipe(minifyCss({compatibility: 'ie8'}))
    .pipe(gulp.dest('./insertagram/css/'));
});

// default
//gulp.task('default', ['mongodump', 'mongorestore']);

// one
//gulp.task('one', ['concatRequire', 'minifyCss']);