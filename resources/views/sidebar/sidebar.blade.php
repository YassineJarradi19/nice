
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="{{set_active(['home','em/dashboard'])}} submenu">
                    <a href="#" class="{{ set_active(['home','em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span> Dashboard</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['home'])}}" href="{{ route('home') }}">Admin Dashboard</a></li>
                       <!-- <li><a class="{{set_active(['em/dashboard'])}}" href="{{ route('em/dashboard') }}">Employee Dashboard</a></li>    -->
                    </ul>
                </li>
                
                <li class="{{set_active(['create/estimate/page','form/estimates/page'])}} submenu">
                    <a href="#" class="{{ set_active(['create/estimate/page','form/estimates/page',]) ? 'noti-dot' : '' }}">
                        <i class="la la-files-o"></i>
                        <span> Demandes </span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['create/estimate/page','form/estimates/page'])}}" href="{{ route('form/estimates/page') }}">Nouvelle demande</a></li>
                        
                    </ul>
                </li>
                @if((auth()->user()->role_name === 'Admin'))
                <li class="{{ set_active(['user/manage']) }} submenu">
                    <a href="{{ route('user.manage') }}">  <!-- Update this line -->
                        <i class="la la-user"></i>
                        <span> User Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('user/manage*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{ set_active('user/manage') }}" href="{{ route('user.manage') }}">Manage Users</a></li>
                    </ul>
                </li>

                @endif
                
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->