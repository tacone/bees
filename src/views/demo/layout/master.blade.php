<!DOCTYPE html>
<html lang="en">
<head id="Starter-Site">
    <meta charset="UTF-8">
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        @section('title')
            Administration
        @show
    </title>
    <!--  Mobile Viewport Fix -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!-- This is the traditional favicon.
     - size: 16x16 or 32x32
     - transparency is OK
     - see wikipedia for info on browser support: http://mky.be/favicon/ -->
    <link rel="shortcut icon" href="{{{ asset('favicon.ico') }}}">

    @yield('styles')

            <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>
<!-- Container -->
<div class="container">
    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-inverse" role="navigation">
        <div class="container">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {{--<a class="navbar-brand" href="/">Bees test</a>--}}
            </div>
            <div class="collapse navbar-collapse">
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>
    <!-- ./ navbar -->


    <!-- Content -->
    <div class="container variations-container">
        <div class="pull-right">
            @yield('variations')
        </div>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Result</a></li>
            <li class=""><a data-toggle="tab" href="#code">Code</a></li>
        </ul>

    </div>
    <div class="container" id="main">
        <div class="row">
            <div class="col-xs-7">


                <div class="tab-content tab-pane">
                    <div class="tab-pane fade in active" id="home">
                        <div class="demo">
                            @yield('content')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="code">
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- ./ content -->

    <!-- Footer -->
    <footer class="clearfix">
        @yield('footer')
    </footer>
    <!-- ./ Footer -->

</div>
<!-- ./ container -->

<!-- Javascripts -->
<script src="/js/jquery-1.10.2.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/prettify.js"></script>
{{--<script>--}}
{{--//    prettyPrint();--}}
{{--</script>--}}
<div class="demo-form-debug">
    @if ($demo->widget)
        {{--{{ \Kint::dump($demo->widget) }}--}}
    @endif
</div>
<script>
    $(function () {
        $('.demo-form-debug').insertAfter('nav');
    });
</script>

@yield('scripts')


</body>

</html>
