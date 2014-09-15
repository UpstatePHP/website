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
    <meta property="og:image" content="http://upstatephp.com/images/upstatephp-logo.jpg" />
    <meta property="og:description" content="UpstatePHP is a group of like minded professionals helping to build a better community, specifically in the Upstate of South Carolina." />

    {{ Orchestra\Asset::styles() }}
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