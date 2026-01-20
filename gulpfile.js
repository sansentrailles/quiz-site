// gulpfile.js
const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCss = require('gulp-clean-css');
const fileInclude = require('gulp-file-include');
const browserSync = require('browser-sync').create();
const del = require('del');
const rev = require('gulp-rev');
const revRewrite = require('gulp-rev-rewrite');
const webpack = require('webpack-stream');
const webpackConfig = require('./webpack.config.js');
const path = require('path');
const fs = require('fs');

// Путь к манифесту для deploy
const manifestPath = path.join(__dirname, 'public_html/rev-manifest.json');

// Пути к исходникам
const paths = {
    html: 'frontend/html/**/*.html',
    styles: 'frontend/styles/**/*.scss',
    js: 'frontend/js/main.js',
    // images: 'frontend/images/**/*.*',
    images: 'frontend/images/**/*',
    fonts: 'frontend/fonts/**/*.*',
};

// Пути к папкам назначения
const dest = {
    dev: 'frontend/build',
    prod: 'public_html'
};

// Очистка папки build (для dev и начала deploy)
function cleanBuild() {
    return del(['frontend/build/**/*', '!frontend/build']);
}

// Очистка папки public_html (для deploy)
function cleanPublic() {
    return del(['public_html/**/*', '!public_html']);
}

// Обработка HTML (сборка из частей)
function processHtml(targetFolder, manifest = null) {
    let stream = gulp.src(paths.html)
        .pipe(fileInclude({
            prefix: '@@',
            basepath: '@file'
        }));

    // Если есть манифест (deploy mode), заменяем пути на хешированные
    if (manifest) {
        stream = stream.pipe(revRewrite({ 
            manifest: manifest 
        }));
    }

    return stream.pipe(gulp.dest(targetFolder));
}

// Задача для HTML (dev)
function htmlDev() {
    return processHtml(dest.dev);
}

// Задача для HTML (deploy)
function htmlDeploy() {
    // Вместо gulp.src читаем файл физически, если он существует
    let manifest;
    if (fs.existsSync(manifestPath)) {
        manifest = fs.readFileSync(manifestPath);
    }
    
    return processHtml(dest.prod, manifest);
}

// Обработка стилей
function processStyles(targetFolder, isMinify) {
    let stream = gulp.src('frontend/styles/main.scss')
        .pipe(sass().on('error', sass.logError));

    if (isMinify) {
        stream = stream.pipe(cleanCss());
    }

    // В dev копируем как main.css, в deploy добавляем хеш через rev()
    if (!isMinify) {
        return stream.pipe(gulp.dest(`${targetFolder}/css`));
    } else {
        return stream
            .pipe(rev())
            .pipe(gulp.dest(`${targetFolder}/css`))
            .pipe(rev.manifest(manifestPath, {
                base: dest.prod,
                merge: true // Объединяем с манифестом от JS
            }))
            .pipe(gulp.dest(dest.prod));
    }
}

function stylesDev() {
    return processStyles(dest.dev, false);
}

function stylesDeploy() {
    // Синхронное удаление, чтобы гарантировать чистоту перед записью
    if (fs.existsSync(manifestPath)) {
        del.sync(manifestPath);
    }
    return processStyles(dest.prod, true);
}

// Обработка скриптов (через Webpack)
function processScripts(targetFolder, envMode) {
    return gulp.src(paths.js)
        .pipe(webpack({ 
            config: webpackConfig(envMode) 
        }))
        .pipe(gulp.dest(`${targetFolder}/js`));
}

function scriptsDev() {
    return processScripts(dest.dev, 'development');
}

function scriptsDeploy() {
    // Webpack собирает файл. После этого нам нужно его переименовать (хеш)
    // и записать в манифест. Так как webpack-stream отдает файлы, мы можем пайпить их.
    return gulp.src(paths.js)
        .pipe(webpack({ 
            config: webpackConfig('production') 
        }))
        .pipe(rev()) // Добавляем хеш к имени файла bundle.js
        .pipe(gulp.dest(`${dest.prod}/js`))
        .pipe(rev.manifest(manifestPath, {
            base: dest.prod,
            merge: true
        }))
        .pipe(gulp.dest(dest.prod));
}

// Перемещение статики (img, fonts)
function moveAssets(targetFolder) {
    return gulp.src([paths.images, paths.fonts], { 
        base: 'frontend/',
        encoding: false 
    })
    .pipe(gulp.dest(targetFolder));
}

function assetsDev() {
    return moveAssets(dest.dev);
}

function assetsDeploy() {
    return moveAssets(dest.prod);
}

// Сервер
function serve() {
    browserSync.init({
        server: {
            baseDir: dest.dev // Сервер смотрит в папку frontend/build
        },
        notify: true,
        open: true
    });

    // При изменении исходников запускаем задачу сборки, 
    // BrowserSync обновит страницу после завершения задачи
    gulp.watch(paths.html, gulp.series(htmlDev)).on('change', browserSync.reload);
    gulp.watch(paths.styles, gulp.series(stylesDev)).on('change', browserSync.reload);
    
    // Для JS (если webpack не в watch-режиме внутри себя):
    gulp.watch('frontend/js/**/*.js', gulp.series(scriptsDev)).on('change', browserSync.reload);
    
    gulp.watch([paths.images, paths.fonts], gulp.series(assetsDev)).on('change', browserSync.reload);
}


// Сценарии
const buildDev = gulp.series(
    cleanBuild,
    gulp.parallel(htmlDev, stylesDev, scriptsDev, assetsDev)
);

const buildDeploy = gulp.series(
    cleanBuild, // Требование: очистить frontend/build
    cleanPublic,
    gulp.series(
        // Сначала собираем статику с хешами (создает manifest.json)
        gulp.parallel(stylesDeploy, scriptsDeploy, assetsDeploy),
        // Затем собираем HTML, подставляя правильные имена из manifest.json
        // htmlDeploy
    )
);

// Экспорт задач
exports.dev = gulp.series(buildDev, serve);
exports.deploy = buildDeploy;
exports.clean = cleanBuild;