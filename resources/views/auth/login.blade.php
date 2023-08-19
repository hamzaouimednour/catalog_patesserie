
<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Takacim - Login System</title>

    <!-- vendor css -->
    <link href="{{ asset('assets/static/lib/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/static/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('assets/static/css/bracket.css') }}">
  </head>

  <body>

    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

      <div class="login-wrapper wd-400 wd-xs-400 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse mb-5"> <span class="tx-normal" style="color:#ffc040;">[ </span>TAKACIM<small
                class="" style="color:#ffc040;"> &copy;</small> <span class="tx-normal" style="color:#ffc040;">]</span></div>

        <div id="login_msg"></div>
        {{-- <div class="tx-center mg-b-60">The Admin Template For Perfectionist</div> --}}
        <form id="login-form" class="form-horizontal" method="POST" action="{{ route('authenticate') }}">
            
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon ion-ios-person tx-16 lh-0 op-6"></i></span>
                        </div>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Nom d'utilisateur"
                            value="{{ old('username') }}" required autofocus>
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon ion-android-lock tx-16 lh-0 op-6"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                    </div>
                    <div class="form-group">
                        
                        {{-- <a href="" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a> --}}
                    </div><!-- form-group -->
{{-- 
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif --}}
                </div>
            </div>

        
        <button type="submit" class="btn btn-block font-weight-bold" style="color:#000;background-color: #ffc040;border-color: #ebaa26;">Se Connecter</button>

        </form>
        {{-- <div class="mg-t-60 tx-center">Not yet a member? <a href="" class="tx-info">Sign Up</a></div> --}}
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->

    <script src="{{ asset('assets/static/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/scripts/login.js') }}"></script>
    <script src="{{ asset('assets/static/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ asset('assets/static/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  </body>
</html>
