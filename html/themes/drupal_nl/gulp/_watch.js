'use strict'

import gulp from 'gulp'
import * as conf from './_conf'

gulp.task('watch', ['build'], () => {
  gulp.watch(conf.paths.styles.src, ['build'])
})
