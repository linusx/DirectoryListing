var gulp = require('gulp'),
	sass = require('gulp-sass'),
	sourcemaps  = require('gulp-sourcemaps'),
	autoprefixer = require('gulp-autoprefixer'),
	cssnano = require('gulp-cssnano'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	concat = require('gulp-concat'),
	notify = require('gulp-notify'),
	cache = require('gulp-cache'),
	del = require('del');

gulp.task('sass', function() {
	return gulp.src('./src/sass/styles.scss')
		.pipe(sourcemaps.init())
		.pipe(sass().on('error', sass.logError))
		.pipe(sourcemaps.write())
		.pipe(autoprefixer('last 2 version'))
		.pipe(gulp.dest('./css'))
		.pipe(rename({suffix: '.min'}))
		.pipe(cssnano())
		.pipe(gulp.dest('./css'))
		.pipe(notify({ message: 'Sass task complete' }));
});

// Default task
gulp.task('default', [], function() {
	gulp.start('sass');
});