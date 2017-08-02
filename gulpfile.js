'use strict'

var gulp = require('gulp')
var sass = require('gulp-sass')
var bs = require('browser-sync').create()

gulp.task('sass', function() {
  return gulp.src('./src/sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./public/css/'))
    .pipe(bs.stream())
})

gulp.task('browser-sync', function() {
  bs.init({
    proxy: 'localhost:8000/p/'
  })
  gulp.watch('./src/sass/**/*.scss', ['sass'])
  gulp.watch('./public/**/*.php').on('change', bs.reload)
})

gulp.task('default', ['browser-sync'])


