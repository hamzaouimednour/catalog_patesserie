    <!-- ########## START: HEAD PANEL ########## -->
    <div class="br-header">
      <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
      </div><!-- br-header-left -->
      <div class="br-header-right">
        <nav class="nav">
            <div class="dropdown">
                <a href="#" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
                <i class="icon ion-ios-email-outline tx-24"></i>
                <!-- start: if statement -->
                {{-- <span class="square-8 bg-danger pos-absolute t-15 r-0 rounded-circle"></span> --}}
                <!-- end: if statement -->
                </a>
                <!-- dropdown-menu -->
            </div>
            <!-- dropdown -->


            <div class="dropdown">
                <a href="#" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
                    <i class="icon ion-ios-bell-outline tx-24"></i>
                    <!-- start: if statement -->
                    {{-- <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span> --}}
                    <!-- end: if statement -->
                </a>
                
                <!-- dropdown-menu -->
            </div>
            <!-- dropdown -->

            <div class="dropdown">
                <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name hidden-md-down text-capitalize tx-inverse">{{Auth::user()->name}}</span>
                    <img src="{{asset('static/avatar.png')}}" class="wd-32 rounded-circle" alt="">
                    <span class="square-10 bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-250">
                    <div class="tx-center">
                        <a href=""><img src="{{asset('static/avatar.png')}}" class="wd-80 rounded-circle" alt=""></a>
                        <h6 class="logged-fullname text-capitalize">{{Auth::user()->name}}</h6>
                        <p>{{Auth::user()->email}}</p>
                    </div>
                    <hr>
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="{{ url('backend/profile') }}"><i class="icon ion-ios-person"></i> Profile</a></li>
                        <li><a href="{{ route('logout') }}"><i class="icon ion-power"></i> Déconnexion</a></li>
                    </ul>
                </div>
                <!-- dropdown-menu -->
            </div>
            <!-- dropdown -->
        </nav>
        <div class="navicon-right">
        <a href="{{url('products')}}" class="pos-relative">
            <i class="icon ion-home"></i>
          </a>
        </div>
        <div class="navicon-right">
        <a href="{{route('logout')}}" class="pos-relative">
            <i class="icon ion-log-out"></i>
          </a>
        </div>
      </div><!-- br-header-right -->
    </div><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->