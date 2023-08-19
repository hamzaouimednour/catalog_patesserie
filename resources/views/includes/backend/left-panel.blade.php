    <!-- ########## START: LEFT PANEL ########## -->
    @php
        $currentRouteName =  explode(".", Route::currentRouteName())[0];
    @endphp
    
    <div class="br-logo"><img class="ht-60 wd-150" src="{{ asset("/static/logo.png")}}" alt=""></div>
    <div class="br-sideleft sideleft-scrollbar bg-black">
        <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
        <ul class="br-sideleft-menu">

            <li class="br-menu-item">
                <a href="{{ url('#') }}" class="br-menu-link {{$currentRouteName == "dashboard" ? 'active' : ''}}">
                    <i class="menu-item-icon fa fa-home tx-20"></i>
                    <span class="menu-item-label">Dashboard</span>
                </a>
            </li>

            @php
                $perms = Session::get('perms')
            @endphp
            
            @if (Session::get('is_admin') || $perms->where('controller', 'products')->isNotEmpty() || $perms->where('controller', 'tags')->isNotEmpty())
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub {{in_array($currentRouteName, ["products", "tags"]) ? 'active' : ''}}">
                    <i class="menu-item-icon icon ion-android-restaurant tx-20"></i>
                    <span class="menu-item-label">Produits</span>
                </a><!-- br-menu-link -->
                <ul class="br-menu-sub">
                    @if (Session::get('is_admin') || $perms->where('controller', 'products')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/products') }}" class="sub-link {{$currentRouteName == "products" ? 'active' : ''}}">Produits</a></li>
                    @endif

                    @if (Session::get('is_admin') || $perms->where('controller', 'tags')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/tags') }}" class="sub-link {{$currentRouteName == "tags" ? 'active' : ''}}">Familles</a></li>
                        <li class="sub-item"><a href="{{ url('backend/sub-tags') }}" class="sub-link {{$currentRouteName == "sub-tags" ? 'active' : ''}}">Sous Familles</a></li>
                    @endif

                </ul>
            </li>
            @endif

            @if (Session::get('is_admin') || $perms->where('controller', 'sizes')->isNotEmpty())
            <li class="br-menu-item">
                <a href="{{ url('backend/sizes') }}" class="br-menu-link {{$currentRouteName == "sizes" ? 'active' : ''}}">
                    <i class="menu-item-icon fa fa-pie-chart tx-18"></i>
                    <span class="menu-item-label">Dimensions</span>
                </a>
            </li>
            @endif
            
            @if (Session::get('is_admin') || $perms->where('controller', 'components')->isNotEmpty())
            <li class="br-menu-item">
                <a href="{{ url('backend/components') }}" class="br-menu-link {{$currentRouteName == "components" ? 'active' : ''}}">
                    <i class="menu-item-icon fa fa-puzzle-piece tx-18"></i>
                    <span class="menu-item-label">Composants</span>
                </a><!-- br-menu-link -->
            </li>
            @endif
            
            {{-- <li class="br-menu-item">
                <a href="{{ url('#') }}" class="br-menu-link {{$currentRouteName == "component-groups" ? 'active' : ''}}">
                    <i class="menu-item-icon icon ion-android-list tx-24"></i>
                    <span class="menu-item-label">Collections</span>
                </a><!-- br-menu-link -->
            </li> --}}

            @if (Session::get('is_admin') || $perms->where('controller', 'orders')->isNotEmpty())
            <li class="br-menu-item">
                <a href="{{ url('backend/orders') }}" class="br-menu-link {{$currentRouteName == "orders" ? 'active' : ''}}">
                    <i class="menu-item-icon icon ion-ios-cart tx-24"></i>
                    <span class="menu-item-label">Commandes</span>
                </a><!-- br-menu-link -->
            </li>
            @endif

            @if (Session::get('is_admin') || $perms->where('controller', 'users')->isNotEmpty() || $perms->where('controller', 'customers')->isNotEmpty() || $perms->where('controller', 'user-permissions')->isNotEmpty())
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub {{in_array($currentRouteName, ["users", "customers", "user-permissions"]) ? 'active' : ''}}">
                    <i class="menu-item-icon icon ion-android-people tx-24"></i>
                    <span class="menu-item-label">Utilisateurs</span>
                </a><!-- br-menu-link -->
                <ul class="br-menu-sub">
                    @if (Session::get('is_admin') || $perms->where('controller', 'users')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/users') }}" class="sub-link {{$currentRouteName == "users" ? 'active' : ''}}">Utilisateurs</a></li>
                    @endif
                    @if (Session::get('is_admin') || $perms->where('controller', 'customers')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/customers') }}" class="sub-link {{$currentRouteName == "customers" ? 'active' : ''}}">Clients</a></li>
                    @endif
                    @if (Session::get('is_admin') || $perms->where('controller', 'user-permissions')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/user-permissions') }}" class="sub-link {{$currentRouteName == "user-permissions" ? 'active' : ''}}">Autorisations</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if (Session::get('is_admin') || $perms->where('controller', 'company')->isNotEmpty() || $perms->where('controller', 'companies')->isNotEmpty() || $perms->where('controller', 'company-sections')->isNotEmpty())
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub {{(in_array($currentRouteName, ["companies", "company-sections", "company"]) || Request::is('backend/company')) ? 'active' : ''}}">
                    <i class="menu-item-icon fa fa-briefcase tx-20"></i>
                    <span class="menu-item-label">Entreprise</span>
                </a><!-- br-menu-link -->
                <ul class="br-menu-sub">
                    @if (Session::get('is_admin') || $perms->where('controller', 'companies')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/companies') }}" class="sub-link {{$currentRouteName == "companies" ? 'active' : ''}}">Entreprises</a></li>
                    @endif
                    @if (Session::get('is_admin') || $perms->where('controller', 'company-sections')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/company-sections') }}" class="sub-link {{$currentRouteName == "company-sections" ? 'active' : ''}}">Sections</a></li>
                    @endif
                    @if (Session::get('is_admin') || $perms->where('controller', 'company')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/company') }}" class="sub-link {{Request::is('backend/company') ? 'active' : ''}}">Informations d'entreprise</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if (Session::get('is_admin') || $perms->where('controller', 'module-groups')->isNotEmpty() || $perms->where('controller', 'modules')->isNotEmpty())
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub {{in_array($currentRouteName, ["modules", "module-groups"]) ? 'active' : ''}}">
                    <i class="menu-item-icon fa fa-sliders tx-20"></i>
                    <span class="menu-item-label">Paramètres</span>
                </a><!-- br-menu-link -->
                <ul class="br-menu-sub">
                    @if (Session::get('is_admin') || $perms->where('controller', 'modules')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/modules') }}" class="sub-link {{$currentRouteName == "modules" ? 'active' : ''}}">Modules</a></li>
                    @endif
                    @if (Session::get('is_admin') || $perms->where('controller', 'module-groups')->isNotEmpty())
                        <li class="sub-item"><a href="{{ url('backend/module-groups') }}" class="sub-link {{$currentRouteName == "module-groups" ? 'active' : ''}}">Groupes d'autorisations</a></li>
                    @endif
                </ul>
            </li>
            @endif

        </ul><!-- br-sideleft-menu -->
        <br>
    </div><!-- br-sideleft -->

    <!-- ########## END: LEFT PANEL ########## -->
