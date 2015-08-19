var elixir = require('laravel-elixir');

// Load plugins
var gulp = require('gulp'),
    plugins = require('gulp-load-plugins')({camelize: true}),
    lr = require('tiny-lr'),
    server = lr();


// Template Styles
gulp.task('template-styles', function () {
    return gulp.src([
        'resources/assets/less/template.less'
    ])
        .pipe(plugins.less())
        .pipe(gulp.dest('resources/assets/css/build'))
        .pipe(plugins.rename('app.min.css'))
        .pipe(plugins.minifyCss({keepSpecialComments: 1}))
        .pipe(gulp.dest('public/css'));
});

// Admin Styles
gulp.task('admin-styles', function () {
    return gulp.src([
        'resources/assets/plugins/bootstrap/dist/css/bootstrap.css',
        'resources/assets/plugins/datatables/dataTables.bootstrap.css',
        'resources/assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css',
        'resources/assets/plugins/bootstrap-markdown/bootstrap-markdown.css',
        'resources/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
        'resources/assets/plugins/iCheck/all.css',
        'resources/assets/admin-lte/AdminLTE.css',
        'resources/assets/admin-lte/skins/skin-purple.css',
        'resources/assets/css/admin.css'
    ])
        .pipe(plugins.concat('admin.min.css'))
        .pipe(plugins.minifyCss({keepSpecialComments: 1}))
        .pipe(gulp.dest('public/css'));
});

// Frontend Scripts
gulp.task('main', function () {
    return gulp.src([
        'resources/assets/plugins/bootstrap/js/transition.js',
        'resources/assets/plugins/bootstrap/js/alert.js',
        'resources/assets/plugins/bootstrap/js/button.js',
        'resources/assets/plugins/bootstrap/js/carousel.js',
        'resources/assets/plugins/bootstrap/js/collapse.js',
        'resources/assets/plugins/bootstrap/js/dropdown.js',
        'resources/assets/plugins/bootstrap/js/modal.js',
        'resources/assets/plugins/bootstrap/js/tooltip.js',
        'resources/assets/plugins/bootstrap/js/popover.js',
        'resources/assets/plugins/bootstrap/js/scrollspy.js',
        'resources/assets/plugins/bootstrap/js/tab.js',
        'resources/assets/plugins/bootstrap/js/affix.js',
        'resources/assets/plugins/gmaps/gmaps.js',
        'resources/assets/plugins/jquery-validation/jquery.validate.js',
        'resources/assets/js/main.js'
    ])
        .pipe(plugins.concat('main.min.js'))
        .pipe(plugins.uglify())
        .pipe(gulp.dest('public/js'));
});

// Admin Scripts
gulp.task('admin', function () {
    return gulp.src([
        'resources/assets/plugins/bootstrap/dist/js/bootstrap.js',
        'resources/assets/plugins/datatables/jquery.dataTables.js',
        'resources/assets/plugins/datatables/dataTables.bootstrap.js',
        'resources/assets/plugins/moment/moment.js',
        'resources/assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js',
        'resources/assets/plugins/sparkline/jquery.sparkline.js',
        'resources/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'resources/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'resources/assets/plugins/knob/jquery.knob.js',
        'resources/assets/plugins/iCheck/icheck.min.js',
        'resources/assets/plugins/slimScroll/jquery.slimscroll.js',
        'resources/assets/plugins/fastclick/fastclick.js',
        'resources/assets/plugins/bootstrap-markdown/markdown.js',
        'resources/assets/plugins/bootstrap-markdown/to-markdown.js',
        'resources/assets/plugins/bootstrap-markdown/bootstrap-markdown.js',
        'resources/assets/admin-lte/app.js',
        'resources/assets/js/admin.js'
    ])
        .pipe(plugins.concat('admin.min.js'))
        .pipe(plugins.uglify())
        .pipe(gulp.dest('public/js'));
});


gulp.task('default', ['template-styles', 'main', 'admin', 'admin-styles']);
gulp.task('backend', ['admin', 'admin-styles']);
