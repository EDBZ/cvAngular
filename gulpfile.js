//sudo gulp init
//sudo npm install --save gulp gulp-angular-htmlify gulp-csscomb gulp-autoprefixer gulp-cssbeautify gulp-htmlmin gulp-image gulp-angular-injector gulp-bower-files-from-html gulp-bower-files-from-html gulp-useref gulp-if gulp-concat gulp-uglify gulp-clean-css gulp-connect-php gulp-util vinyl-ftp gulp-livereload run-sequence

// Requis
var gulp = require('gulp');

// Include plugins
var htmlify = require('gulp-angular-htmlify');
var csscomb = require('gulp-csscomb');
var autoprefixer = require('gulp-autoprefixer');
var cssbeautify = require('gulp-cssbeautify');
var htmlmin = require('gulp-htmlmin');
var image = require('gulp-image');
var angularInjector = require('gulp-angular-injector');
var gulpBowerFilesFromHtml = require('gulp-bower-files-from-html');
var notify = require('gulp-notify');
var useref = require('gulp-useref');
var gulpif = require('gulp-if');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');
var php = require('gulp-connect-php');
var gutil = require('gulp-util');
var ftp = require('vinyl-ftp');
var watch = require('gulp-watch');
var livereload = require('gulp-livereload');
var runSequence = require('run-sequence');

// Variables de chemins================================
var source = './src/'; // dossier de travail
var dev = './dev/'; // dossier à livrer
var prod = './prod/'; // dossier enligne

// Tache Déploiement sur page perso free==========================
gulp.task('deploy', function() {
  var conn = ftp.create({
    host: 'ftpperso.free.fr',
    user: 'emmanuel.debuire',
    password: '1753vy31',
    parallel: 1,
    maxConnections: 2,
    log: gutil.log
  });
  var globs = [
    prod + '**/**/**'
  ];
  return gulp.src(globs, {
      buffer: false
    })
    .pipe(conn.newer('/')) // only upload newer files
    .pipe(conn.dest('/'))
    .on('error', function(err) {
      console.error('Error in deploy task', err.toString())
    });
});

// Tache Serveur====================================
gulp.task('server', function() {
  php.server({
    port: 3000,
    base: dev
  });
  php.server({
    port: 3030,
    base: prod
  });

});

// Tâche Html======================================
gulp.task('htmldev', function() {
  return gulp.src(source + '**/*.html', {
      base: source
    })
    .pipe(htmlify())
    .pipe(gulp.dest(dev))
    .on('error', function(err) {
      console.error('Error in html task', err.toString())
    })
    .pipe(notify({
      message: 'htmldev task complete',
      onLast: true
    }))
    .pipe(livereload({
      start: true
    }));
});

gulp.task('htmlprod', function() {
  return gulp.src(dev + '**/*.html', {
      base: dev
    })
    .pipe(useref())
    .pipe(gulpif('*.js', uglify()))
    .pipe(gulpif('controller/*.js', concat('controller.min.js')))
    .pipe(gulpif('service/*.js', concat('service.min.js')))
    .pipe(gulpif('*.css', cleanCSS({
      compatibility: 'ie8'
    })))
    .pipe(gulp.dest(prod))
    .on('error', function(err) {
      console.error('Error in htmlprod task', err.toString())
    })
    .pipe(notify({
      message: 'htmlprod task complete',
      onLast: true
    }));
});

gulp.task('htmlmin', function() {
  return gulp.src(prod + '**/*.html', {
      base: prod
    })
    .pipe(htmlmin({
      collapseWhitespace: true,
      conservativeCollapse: true,
      removeComments: true
    }))
    .pipe(gulp.dest(prod));
});

gulp.task('logo',function(){
  return gulp.src(['logo.html',prod+'index.html'])
  .pipe(concat('index.html'))
  .pipe(gulp.dest(prod));
});

// Tâche CSS===========================================
gulp.task('css', function() {
  return gulp.src(source + 'css/*')
    .pipe(csscomb())
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(cssbeautify({
      indent: ''
    }))
    .pipe(gulp.dest(dev + 'css/'))
    .on('error', function(err) {
      console.error('Error in css task', err.toString())
    })
    .pipe(notify({
      message: 'css task complete',
      onLast: true
    }))
    .pipe(livereload({
      start: true
    }));
});

// Tache Js======================================
gulp.task('jsdev', function() {
  return gulp.src(source + 'js/**/*.js', {
      base: source
    })
    .pipe(angularInjector())
    .pipe(gulp.dest(dev))
    .on('error', function(err) {
      console.error('Error in jsdev task', err.toString())
    })
    .pipe(notify({
      message: 'jsdev task complete',
      onLast: true
    }))
    .pipe(livereload({
      start: true
    }));
});

// Tache Bower==============================================
gulp.task('bower', function() {
  return gulp.src(source + 'index.html', {
      base: source
    })
    .pipe(gulpBowerFilesFromHtml())
    .pipe(gulp.dest(dev))
    .pipe(notify({
      message: 'bower task complete',
      onLast: true
    }))
    .pipe(livereload({
      start: true
    }));
});

// Tâche image======================================
gulp.task('image', function() {
  return gulp.src(source + '/img/*')
    .pipe(image())
    .pipe(gulp.dest(dev + '/img/'))
    .on('error', function(err) {
      console.error('Error in image task', err.toString())
    })
    .pipe(notify({
      message: 'image task complete',
      onLast: true
    }))
    .pipe(livereload({
      start: true
    }));
});

// Taches copie files==================================
gulp.task('copyfontdev', function() {
  gulp.src(source + 'font/*')
    .pipe(gulp.dest(dev + 'font'));
});
gulp.task('copyfontprod', function() {
  gulp.src(dev + 'font/*')
    .pipe(gulp.dest(prod + 'font'));
});
gulp.task('copyphpdev', function() {
  gulp.src(source + 'php/*')
    .pipe(gulp.dest(dev + 'php'));
});
gulp.task('copyphpprod', function() {
  gulp.src(dev + 'php/*')
    .pipe(gulp.dest(prod + 'php'));
});
gulp.task('htaccessprod', function() {
  gulp.src(source + '.htaccess')
    .pipe(gulp.dest(prod));
});
gulp.task('bowerprod', function() {
  gulp.src(dev + 'bower_components/**', {
      base: dev
    })
    .pipe(gulp.dest(prod));
});
gulp.task('imageprod', function() {
  gulp.src(dev + 'img/**', {
      base: dev
    })
    .pipe(gulp.dest(prod));
});
gulp.task('copyglyphdev', function() {
  gulp.src('./bower_components/bootstrap/dist/fonts/*')
    .pipe(gulp.dest(dev + '/bower_components/bootstrap/dist/fonts'));
});
gulp.task('copyviewprod', function() {
  gulp.src(dev + 'views/*', {
      base: dev
    })
    .pipe(gulp.dest(prod));
});

gulp.task('copyprod', ['copyviewprod', 'imageprod', 'bowerprod', 'htaccessprod', 'copyfontprod', ])

// WATCH ===========================================
gulp.task('watch', function() {
  livereload.listen();
  gulp.watch(source + 'css/*', ['css']);
  gulp.watch(source + 'js/**', ['jsdev']);
  gulp.watch(source + '/img/*', ['image']);
  gulp.watch(source + '**/*.html', ['htmldev']);
});

// Tâche "prod"====================================================
gulp.task('build', function(callback) {
  runSequence('htmldev', 'css', 'jsdev', 'copyphpdev', 'bower', 'image', 'copyfontdev', 'copyglyphdev', callback);
});
gulp.task('prod', function(callback) {
  runSequence('htmlprod', 'htmlmin','logo', 'copyviewprod', 'copyphpprod', 'bowerprod', 'imageprod', 'copyfontprod', 'htaccessprod', callback);
});
gulp.task('default', ['build']);
