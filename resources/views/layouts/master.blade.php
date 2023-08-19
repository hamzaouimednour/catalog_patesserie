<!DOCTYPE html>
<html lang="fr">
    <head>
        
        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('includes.backend.head')

    </head>

    <body>
        <!--=== PRELOADER ===-->
        {{-- <div class="preloader">
            <div class="loder-content">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
            </div>
            </div>
        </div> --}}
        @include('includes.backend.left-panel')
        
        @include('includes.backend.head-panel')

        <!-- ########## START: MAIN PANEL ########## -->
        <div class="br-mainpanel">
        
            @include('includes.backend.page-title')

            <div class="br-pagebody">
                <div class="br-section-wrapper">

                    @yield('content')

                </div><!-- br-section-wrapper -->
            </div><!-- br-pagebody -->

            @include('includes.backend.footer')

        </div><!-- br-mainpanel -->
        <!-- ########## END: MAIN PANEL ########## -->

        <!-- ########## START: FOOTER SCRIPTS ########## -->
        @include('includes.backend.footer-scripts')
        <!-- ########## END: FOOTER SCRIPTS ########## -->
        
    </body>
</html>