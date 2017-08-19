'use strict'

var gulp = require('gulp')
var sass = require('gulp-sass')
// var concat = require('gulp-concat')
var bs = require('browser-sync').create()

gulp.task('style', function() {
  return gulp.src('./src/scss/**/style.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./public/css/'))
    .pipe(bs.stream())
})

gulp.task('bs-style', function() {
  return gulp.src('./src/scss/bootstrap4-beta/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./public/css/'))
    .pipe(bs.stream())
})

// gulp.task('bs-script', function() {
//   return gulp.src('./src/js/**/**.js')
//     .pipe()
//     .pipe(gulp.dest('./public/js/'))
//     .pipe(bs.stream())
// })

gulp.task('browser-sync', function() {
  bs.init({
    proxy: 'localhost:8000/p/'
  })
  gulp.watch('./src/scss/**/style.scss', ['style'])
  gulp.watch('./public/**/*.php').on('change', bs.reload)
})

gulp.task('default', ['browser-sync'])


