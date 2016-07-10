var gulp       = require('gulp')
  , concat     = require('gulp-concat')
  , uglify     = require('gulp-uglify')
  , livereload = require('gulp-livereload');

gulp.task('scripts', function () {
  gulp.src([
    // MediumEditor library
    'bower_components/medium-editor/dist/js/medium-editor.js'

    // Editor plugin
  , 'js/editor.js'

    // Plugin initialization
  , 'js/initialize.js'
  ])
    .pipe(uglify())
    .pipe(concat('editor.min.js'))
    .pipe(gulp.dest('js'))
    .pipe(livereload());
});

gulp.task('watch', function () {
  gulp.watch(['js/**/*.js', '!js/editor.min.js'], ['concat']);
});
