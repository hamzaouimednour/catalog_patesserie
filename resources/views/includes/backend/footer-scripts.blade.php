    
    @section('js')
        <script src="{{ asset('assets/static/lib/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/static/lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>
        <script src="{{ asset('assets/static/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/static/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/static/lib/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('assets/static/lib/peity/jquery.peity.min.js') }}"></script>
        <script src="{{ asset('assets/static/lib/highlightjs/highlight.pack.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/static/lib/select2/js/select2.min.js') }}"></script> --}}
        <script src="{{ asset('assets/static/lib/parsleyjs/parsley.min.js') }}"></script>

        <script src="{{ asset('assets/static/js/bracket.js') }}"></script>
        <script src="{{ asset('assets/static/js/script.js') }}"></script>
        <script>
          $(function(){
            'use strict';

            $('#selectForm').parsley();
            $('#selectForm2').parsley();
          });
        </script>
    @show