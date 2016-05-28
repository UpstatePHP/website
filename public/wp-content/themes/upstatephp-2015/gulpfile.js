// Load plugins
var gulp = require('gulp'),
    plugins = require('gulp-load-plugins')({camelize: true}),
    lr = require('tiny-lr'),
    server = lr();


// Template Styles
gulp.task('template-styles', function () {
    return gulp.src([
        'assets/less/template.less'
    ])
        .pipe(plugins.less())
        .pipe(gulp.dest('assets/css/build'))
        .pipe(plugins.rename('site.min.css'))
        .pipe(plugins.minifyCss({keepSpecialComments: 1}))
        .pipe(gulp.dest('assets/css'));
});

// Frontend Scripts
gulp.task('main', function () {
    return gulp.src([
        'assets/plugins/bootstrap/js/transition.js',
        'assets/plugins/bootstrap/js/alert.js',
        'assets/plugins/bootstrap/js/button.js',
        'assets/plugins/bootstrap/js/carousel.js',
        'assets/plugins/bootstrap/js/collapse.js',
        'assets/plugins/bootstrap/js/dropdown.js',
        'assets/plugins/bootstrap/js/modal.js',
        'assets/plugins/bootstrap/js/tooltip.js',
        'assets/plugins/bootstrap/js/popover.js',
        'assets/plugins/bootstrap/js/scrollspy.js',
        'assets/plugins/bootstrap/js/tab.js',
        'assets/plugins/bootstrap/js/affix.js',
        'assets/plugins/gmaps/gmaps.js',
        'assets/plugins/jquery-validation/jquery.validate.js',
        'assets/js/main.js'
    ])
        .pipe(plugins.concat('site.min.js'))
        .pipe(plugins.uglify())
        .pipe(gulp.dest('assets/js'));
});


gulp.task('default', ['template-styles', 'main']);
