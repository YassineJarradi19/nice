<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="{{ set_active(['home','em/dashboard']) }} submenu">
                    <a href="#" class="{{ set_active(['home','em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span> Dashboard</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{ set_active(['home']) }}" href="{{ route('home') }}">Admin Dashboard</a></li>
                    </ul>
                </li>
                
                <li class="{{ set_active(['create/estimate/page','form/estimates/page']) }} submenu">
                    <a href="#" class="{{ set_active(['create/estimate/page','form/estimates/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-files-o"></i>
                        <span> Demandes </span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{ set_active(['create/estimate/page','form/estimates/page']) }}" href="{{ route('form/estimates/page') }}">Listes demande</a></li>
                    </ul>
                </li>

                @if(auth()->user()->role_name == 'Validateur') <!-- Check if user role_name is validator -->
                <li class="{{ request()->is('validator/*') ? 'active submenu' : 'submenu' }}">
                    <a href="javascript:void(0);">
                        <i class="la la-check-circle"></i>
                        <span> Validator Interface </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('validator/*') ? 'display: block;' : 'display: none;' }}">
                        
                        <li>
                            <a class="{{ request()->routeIs('validator.requests') ? 'active' : '' }}" href="{{ route('validator.requests') }}">
                                Liste de demande à valider
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(auth()->user()->admin == 1) <!-- Check if user is admin by admin attribute -->
                <li class="{{ request()->is('user/*') ? 'active submenu' : 'submenu' }}">
                    <a href="javascript:void(0);">
                        <i class="la la-user"></i>
                        <span> User Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('user/*') ? 'display: block;' : 'display: none;' }}">
                        <li>
                            <a class="{{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                Listes des utilisateurs
                            </a>
                        </li>
                        
                    </ul>
                </li>
                @endif
                
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
