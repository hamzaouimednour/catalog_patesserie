
      <title>Managment Section - @yield('title')</title>
      <link rel='shortcut icon' type='image/x-icon' href='{{ asset('static/logo.ico') }}' />
      @section('css')
      <!-- vendor css -->
      <link href="{{ asset('assets/static/lib/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
      <link href="{{ asset('assets/static/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
      <link href="{{ asset('assets/static/lib/highlightjs/styles/github.css') }}" rel="stylesheet">
      <link href="{{ asset('assets/static/lib/select2/css/select2.min.css') }}" rel="stylesheet">
      <link href="{{ asset('assets/static/lib/spinkit/css/spinkit.css') }}" rel="stylesheet">
      @section('before-css')@show
      <!-- Bracket CSS -->
      <link rel="stylesheet" href="{{ asset('assets/static/css/bracket.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/static/css/master.css') }}">
      @show
