<html>
<!--<![endif]-->
<head>
    <meta name="viewport" content="width=device-width" /></title>

    <title>UpstatePHP</title>
    <meta name="description" content="UpstatePHP is a group of like minded professionals helping to build a better community, specifically in the Upstate of South Carolina." />

    <!-- Open Graph data -->
    <meta property="og:title" content="UpstatePHP" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="http://upstatephp.com/" />
    <meta property="og:image" content="http://upstatephp.com/images/upstatephp-logo.png" />
    <meta property="og:description" content="UpstatePHP is a group of like minded professionals helping to build a better community, specifically in the Upstate of South Carolina." />

    {{ Orchestra\Asset::styles() }}

    <!-- Testing an update via Dploy.io -->

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-54800737-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body>

    <div id="site-header" class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="/" id="main-brand" class="navbar-brand">
                    <img src="/images/upstatephplogo.svg" alt="UpstatePHP" id="header-logo" />
                    <span id="header-name">UpstatePHP</span>
                </a>
            </div>
            @include('partials.menu')
        </div>
    </div>