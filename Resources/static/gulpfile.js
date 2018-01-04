'use strict';

var gulp = require('gulp'),
    path = require('path'),
    concat = require('gulp-concat'),
    del = require('del'),
    sass = require('gulp-sass'),
    plumber = require('gulp-plumber'),
    flatten = require('gulp-flatten'),
    autoprefixer = require('autoprefixer'),
    postcss = require('gulp-postcss'),
    flexbugs = require('postcss-flexbugs-fixes'),
    csso = require('postcss-csso'),
    watch = require('gulp-watch'),
    browserSync = require('browser-sync').create(),
    nodesass = require('node-sass');

console.log(nodesass.info);

var dst = {
    css: '../public/css',
    images: '../public/images',
    fonts: '../public/fonts'
};

var paths = {
    images: [
        './images/**/*'
    ],
    fonts: [
        './fonts/**/*{.eot,.ttf,.woff,.woff2,.svg}',
        './node_modules/material-design-icons/iconfont/**/*{.eot,.ttf,.woff,.woff2,.svg}',
    ],
    css: [
        './fonts/**/*.css',
        './scss/**/*.scss'
    ]
};

gulp.task('images', function () {
    return gulp.src(paths.images)
        .pipe(gulp.dest(dst.images))
        .pipe(browserSync.stream());
});

gulp.task('fonts', function () {
    return gulp.src(paths.fonts)
        .pipe(plumber())
        .pipe(flatten())
        .pipe(gulp.dest(dst.fonts));
});

gulp.task('css', function () {
    const plugins = [
        flexbugs,
        autoprefixer({
            browsers: [
                '>1%',
                'last 4 versions',
                'Firefox ESR',
                'not ie < 9' // React doesn't support IE8 anyway
            ],
            // cascade: false,
            flexbox: 'no-2009'
        }),
        csso
    ];

    return gulp.src(paths.css)
        .pipe(plumber())
        .pipe(sass({
            includePaths: [
                'node_modules/flexy-framework'
            ]
        }).on('error', sass.logError))
        .pipe(postcss(plugins))
        .pipe(concat('bundle.css'))
        .pipe(gulp.dest('../public/css'))
        .pipe(browserSync.stream());
});

gulp.task('watch', function () {
    browserSync.init({
        open: false,
        proxy: "localhost:8000"
    });

    watch('../public/js/**/*.js', function () {
        browserSync.reload();
    });

    watch(paths.images, function () {
        gulp.start('images');
        browserSync.reload();
    });

    watch(paths.css, function () {
        gulp.start('css');
    });

    watch(paths.fonts, function () {
        gulp.start('fonts');
        browserSync.reload();
    });
});

gulp.task('clean', function () {
    return del(path.join(__dirname, '../public/*'), { force: true });
});

gulp.task('build', ['css', 'images', 'fonts'], function () {

});

gulp.task('default', ['clean'], function () {
    return gulp.start('build');
});