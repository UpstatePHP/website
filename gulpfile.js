var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');
});

/*
 |-------------------------------------------------------------------------
 | Plugin Styles
 |-------------------------------------------------------------------------
 |
*/

gulp.task('plugin-styles', function() {
  return gulp.src([
    'assets/less/upstate-bootstrap.less'
  ])
  .pipe(plugins.less())
  .pipe(gulp.dest('assets/css/build'))
  .pipe(plugins.rename('plugins.min.css'))
  .pipe(plugins.minifyCss({ keepSpecialComments: 1 }))
  .pipe(gulp.dest('public/css'))
  .pipe(plugins.notify({ message: 'Frontend Plugin Styles task complete' }));
});


// Load plugins
var gulp = require('gulp'),
    plugins = require('gulp-load-plugins')({ camelize: true }),
    lr = require('tiny-lr'),
    server = lr();

// Plugin Styles
gulp.task('plugin-styles', function() {
    return gulp.src([
            'assets/less/upstate-bootstrap.less'
        ])
        .pipe(plugins.less())
        .pipe(gulp.dest('assets/css/build'))
        .pipe(plugins.rename('plugins.min.css'))
        .pipe(plugins.minifyCss({ keepSpecialComments: 1 }))
        .pipe(gulp.dest('public/css'))
        .pipe(plugins.notify({ message: 'Frontend Plugin Styles task complete' }));
});

// Template Styles
gulp.task('template-styles', function() {
    return gulp.src([
            'assets/less/template.less'
        ])
        .pipe(plugins.less())
        .pipe(gulp.dest('assets/css/build'))
        .pipe(plugins.rename('template.min.css'))
        .pipe(plugins.minifyCss({ keepSpecialComments: 1 }))
        .pipe(gulp.dest('public/css'))
        .pipe(plugins.notify({ message: 'Template Styles task complete' }));
});

// Frontend Plugin Scripts
gulp.task('plugins', function() {
    return gulp.src([
            'assets/js/vendor/gmaps.js',
            'bower_components/bootstrap/js/transition.js',
            'bower_components/bootstrap/js/alert.js',
            'bower_components/bootstrap/js/button.js',
            'bower_components/bootstrap/js/carousel.js',
            'bower_components/bootstrap/js/collapse.js',
            'bower_components/bootstrap/js/dropdown.js',
            'bower_components/bootstrap/js/modal.js',
            'bower_components/bootstrap/js/tooltip.js',
            'bower_components/bootstrap/js/popover.js',
            'bower_components/bootstrap/js/scrollspy.js',
            'bower_components/bootstrap/js/tab.js',
            'bower_components/bootstrap/js/affix.js'
        ])
        .pipe(plugins.concat('plugins.js'))
        .pipe(gulp.dest('assets/js/build'))
        .pipe(plugins.rename('plugins.min.js'))
        .pipe(plugins.uglify())
        .pipe(gulp.dest('public/js'))
        .pipe(plugins.notify({ message: 'Plugin Scripts task complete' }));
});

// Frontend Main Script
gulp.task('main', function() {
    return gulp.src([
            'assets/js/main.js'
        ])
        .pipe(plugins.rename('main.min.js'))
        .pipe(plugins.uglify())
        .pipe(gulp.dest('public/js'))
        .pipe(plugins.notify({ message: 'Main Scripts task complete' }));
});

// Admin Plugin Styles
gulp.task('admin-plugin-styles', function() {
    return gulp.src([
            'assets/css/vendor/jquery.datetimepicker.css'
        ])
        .pipe(gulp.dest('assets/css/build'))
        .pipe(plugins.rename('admin-plugins.min.css'))
        .pipe(plugins.minifyCss({ keepSpecialComments: 1 }))
        .pipe(gulp.dest('public/css'))
        .pipe(plugins.notify({ message: 'Admin Plugin Styles task complete' }));
});

// Admin Plugin Scripts
gulp.task('admin-plugins', function() {
    return gulp.src([
            'assets/js/vendor/jquery.datetimepicker.js'
        ])
        .pipe(plugins.concat('admin-plugins.js'))
        .pipe(gulp.dest('assets/js/build'))
        .pipe(plugins.rename('admin-plugins.min.js'))
        .pipe(plugins.uglify())
        .pipe(gulp.dest('public/js'))
        .pipe(plugins.notify({ message: 'Admin Plugin Scripts task complete' }));
});

// Admin Scripts
gulp.task('admin', function() {
    return gulp.src([
            'assets/js/admin.js'
        ])
        .pipe(plugins.rename('admin.min.js'))
        .pipe(plugins.uglify())
        .pipe(gulp.dest('public/js'))
        .pipe(plugins.notify({ message: 'Admin Scripts task complete' }));
});

gulp.task('default', ['plugin-styles', 'template-styles', 'plugins', 'main']);
gulp.task('backend', ['admin-plugin-styles', 'admin-plugins', 'admin']);
