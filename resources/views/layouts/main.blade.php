<html>

@include('partials.header')

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

<div id="page-container">
    <div class="container">
        <div class="row">

        </div>
    </div>

    @yield('body')

</div>

@include('partials.footer')

</body>
</html>
