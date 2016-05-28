<?php
register_sidebar(array(
    'name' => 'Hero Banner',
    'description' => 'widgets shown in this area will be be full width heroes',
    'id' => 'hero-banner',
    'class' => 'hero-banner',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title' => '<h2>',
    'after_title' => '</h2>'
));
register_sidebar(array(
    'name' => 'Right Column',
    'description' => 'widgets for the right column',
    'id' => 'right-column',
    'class' => 'right-column',
    'before_widget' => '<section id="%1$s" class="sidebar-widget widget %2$s">',
    'after_widget'  => '</section>',
    'before_title' => '<h2>',
    'after_title' => '</h2>'
));
register_sidebar(array(
    'name' => 'Home Buckets',
    'description' => 'widgets for the home buckets',
    'id' => 'home-buckets',
    'class' => 'home-buckets',
    'before_widget' => '<section id="%1$s" class="col-lg-4 home-bucket %2$s">',
    'after_widget'  => '</section>',
    'before_title' => '<h3 class="bucket-title">',
    'after_title' => '</h3>'
));
