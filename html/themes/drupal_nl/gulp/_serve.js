'use strict'

import gulp from 'gulp'
import browserSync from 'browser-sync'
import * as conf from './_conf'

gulp.task('serve', ['build'], () => {
  browserSync.init({
    proxy: conf.paths.local
  })

  gulp.watch(conf.paths.styles.src, ['styles-reload'])
})
