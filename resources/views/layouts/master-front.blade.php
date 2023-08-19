<!DOCTYPE html>
<html class="no-js" lang="fr">
    <head>
        
        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="TAKACIM">
        @include('includes.front.head')

    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Body main wrapper start -->
        <div class="wrapper">

            @include('includes.front.header')
        
            @include('includes.front.breadcumb')

            <!-- Start page content -->
            <div id="page-content" class="page-wrapper section">

                @yield('content')

            </div>
            <!-- End page content -->

            <!-- START FOOTER AREA -->
            @include('includes.front.footer')
            <!-- END FOOTER AREA -->

        </div>
        <!-- Body main wrapper end -->

        <!-- Placed JS at the end of the document so the pages load faster -->
        @include('includes.front.footer-scripts')

    </body>
</html>