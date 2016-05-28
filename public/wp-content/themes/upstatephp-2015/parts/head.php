<!doctype html>
<!--[if lt IE 9]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <?php wp_head(); ?>
    <link rel="shortcut icon" href="<?php echo ASSETS_DIR; ?>/images/favicon.ico">

    <!-- Open Graph data -->
    <meta property="og:title" content="UpstatePHP"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="http://upstatephp.com/"/>
    <meta property="og:image" content="<?php echo ASSETS_DIR; ?>/images/upstatephp-logo.png"/>
    <meta property="og:description"
          content="UpstatePHP is a group of like minded professionals helping to build a better community, specifically in the Upstate of South Carolina."/>

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-54800737-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body <?php body_class(); ?>>
    <?php get_template_part('parts/site-header'); ?>
    <div id="page-container">
