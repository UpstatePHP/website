<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UpstatePHP Admin</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->

    {!! Asset::styles() !!}

</head>
<body class="skin-purple">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="#" class="logo">UpstatePHP</a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">Steven Wade</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li>
                                <a href="#">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        @include('backend.partials.sidebar-menu')
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {!! $pageHeader or '' !!}
                @if(isset($pageHeaderDescription))
                    <small>{!! $pageHeaderDescription !!}</small>
                @endif
            </h1>
            <div class="pull-right breadcrumb content-header-actions">
                @yield('content-header-actions')
            </div>
        </section>

        <!-- Main content -->
        <section class="content">

            @yield('main-content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; {!! date('Y') !!} UpstatePHP.</strong> All rights reserved.
    </footer>

</div>
<!-- ./wrapper -->

{!! Asset::container('before-footer')->scripts() !!}
<script>window.jQuery || document.write('<script src="/js/gmaps/jquery.min.js"><\/script>')</script>
{!! Asset::container('footer')->scripts() !!}

</body>
</html>
