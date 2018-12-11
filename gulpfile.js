const gulp = require('gulp')
const sourcemaps = require('gulp-sourcemaps')
const uglify = require('gulp-uglify-es').default
const babel = require('gulp-babel')
const scss = require('gulp-sass')
const concat = require('gulp-concat')
const plumber = require('gulp-plumber')
const rename = require('gulp-rename')
const clean = require('gulp-clean')

function handleError (err) {
  console.log(err.toString())
  this.emit('end')
}

gulp.task('js', function () {
  return gulp.src('./src/assetbundles/purgefastly/src/js/purge-fastly.js')
    .pipe(plumber({ errorHandler: handleError }))
    .pipe(sourcemaps.init())
    .pipe(babel({compact: true}))
    .pipe(concat('purge-fastly.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(rename('purge-fastly.min.js'))
    .pipe(gulp.dest('./src/assetbundles/purgefastly/dist/js'))
})

gulp.task('styles', function () {
  return gulp.src('./src/assetbundles/purgefastly/src/scss/purge-fastly.scss')
    .pipe(plumber({errorHandler: handleError}))
    .pipe(sourcemaps.init())
    .pipe(scss({outputStyle: 'compressed'}))
    .pipe(sourcemaps.write())
    .pipe(rename('purge-fastly.min.css'))
    .pipe(gulp.dest('./src/assetbundles/purgefastly/dist/css'))
})

gulp.task('clean', function () {
  return gulp.src('./src/assetbundles/purgefastly/dist', {read: false})
    .pipe(clean())
})

gulp.task('watch', gulp.parallel(function() {
  gulp.watch('./src/assetbundles/purgefastly/src/js/*.js', gulp.series('js'))
  gulp.watch('./src/assetbundles/purgefastly/src/scss/*.scss', gulp.series('styles'))
}))

gulp.task('default', gulp.series('clean', gulp.parallel('js', 'styles')))