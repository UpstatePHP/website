<?php

Orchestra\Asset::style('google-font', '//fonts.googleapis.com/css?family=Droid+Sans+Mono');
Orchestra\Asset::style('plugins', 'css/plugins.min.css', 'google-font');
Orchestra\Asset::style('template', 'css/template.min.css', ['google-font', 'plugins']);

Orchestra\Asset::container('before-footer')->script('google-maps', '//maps.google.com/maps/api/js?sensor=true');
Orchestra\Asset::container('before-footer')->script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js');

Orchestra\Asset::container('footer')->script('plugins', 'js/plugins.min.js', 'jquery');
Orchestra\Asset::container('footer')->script('main', 'js/main.min.js', ['jquery', 'plugins']);