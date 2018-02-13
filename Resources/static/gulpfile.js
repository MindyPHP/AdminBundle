let gulp = require('gulp');
let browserSync = require('browser-sync').create();
let sass = require('gulp-sass');
let autoprefixer = require('autoprefixer');
let flexbugs = require('postcss-flexbugs-fixes');
let csso = require('postcss-csso');
let sourcemaps = require('gulp-sourcemaps');
let postcss = require('gulp-postcss');
let plumber = require('gulp-plumber');
let flatten = require('gulp-flatten');
let sassTildeImporter = require('node-sass-tilde-importer');
let minifyImg = require('gulp-imagemin');
let del = require('del');

let paths = {
    src: {
        fonts: [
            './node_modules/flexy-icon/fonts/*.{ttf,eot,woff,woff2,svg}',
            './node_modules/clearsans/*.{ttf,eot,woff,woff2,svg}',
            './assets/fonts/**/*.{ttf,eot,woff,woff2,svg}'
        ],
        html: '../templates/**/*.html',
        css: './css/**/*.scss',
        images: './images/**/*.{jpg,jpeg,png,gif,svg}',
    },
    dst: {
        build: '../public',
        fonts: '../public/fonts',
        css: '../public/css',
        images: '../public/images',
    },
};

gulp.task('watch', () => {
    browserSync.init({
        proxy: 'localhost:8000',
        port: 3000,
        open: false,
    });

    gulp.watch(paths.src.css, gulp.series('css'));
    gulp.watch(paths.src.fonts, gulp.series('fonts', 'css'));
    gulp.watch(paths.src.images, gulp.series('images'));
    gulp.watch('../public/js/**/*', gulp.series('refresh'));
    gulp.watch(paths.src.html, gulp.series('refresh'));
});

gulp.task('fonts', () => {
    return gulp
        .src(paths.src.fonts)
        .pipe(plumber())
        .pipe(flatten())
        .pipe(gulp.dest(paths.dst.fonts));
});

gulp.task('clean', cb => {
    return del(paths.dst.build, {
        force: true,
    }, cb);
});

gulp.task('images', () => {
    return gulp
        .src(paths.src.images)
        .pipe(plumber())
        .pipe(minifyImg())
        .pipe(gulp.dest(paths.dst.images));
});

gulp.task('refresh', done => {
    browserSync.reload();
    done();
});

gulp.task('css', () => {
    const sassOptions = {
        importer: sassTildeImporter
    };

    const postCssOptions = [
        flexbugs(),
        autoprefixer({
            browsers: [
                '>1%',
                'last 4 versions',
                'Firefox ESR',
                'not ie < 9',
            ],
            flexbox: 'no-2009',
        }),
        csso(),
    ];

    return gulp
        .src(paths.src.css)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass(sassOptions))
        .pipe(postcss(postCssOptions))
        .pipe(sourcemaps.write('.', { sourceRoot: '/' }))
        .pipe(gulp.dest(paths.dst.css))
        .pipe(browserSync.stream());
});

gulp.task('build', gulp.series('fonts', 'css', 'images'));

gulp.task('default', gulp.series('build', 'watch'));
