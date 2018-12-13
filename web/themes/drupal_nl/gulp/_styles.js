'use strict'

import gulp from 'gulp'
import browserSync from 'browser-sync'
import * as conf from './_conf'

import gulpLoadPlugins from 'gulp-load-plugins'
const $ = gulpLoadPlugins()

/**
 * Compile the SASS files into CSS.
 */
let buildStyles = () => {
  return gulp.src(conf.paths.styles.src)
    .pipe($.sassGlob())
    .pipe($.sass.sync({
      outputStyle: 'expanded',
      includePaths: [
      ]
    }).on('error', $.sass.logError))
    .pipe($.autoprefixer())
    .pipe(gulp.dest(conf.paths.styles.dist))
}

gulp.task('styles', ['clean'], () => {
  return buildStyles()
})

gulp.task('styles-reload', () => {
  return buildStyles()
    .pipe(browserSync.stream())
})
