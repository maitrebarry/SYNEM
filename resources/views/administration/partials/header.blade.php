<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
            
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="alert-count" id="notification-count">0</span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-clear ms-auto">Tout marquer comme lu</p>
                                </div>
                            </a>
                            <div class="header-notifications-list" id="notifications-list">
                                <!-- Notifications dynamiques -->
                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">Voir toutes les notifications</div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Menu utilisateur -->
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->photo ?? asset('template-admin/assets/images/default-user.jpg') }}" class="user-img" alt="user avatar" id="headerUserImg">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ Auth::user()->name ?? 'Admin SYNEM' }}</p>
                        <p class="designattion mb-0">Administrateur</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bx bx-user"></i><span>Mon Profil</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-cog"></i><span>Paramètres</span>
                        </a>
                    </li>
                    <li><div class="dropdown-divider mb-0"></div></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class='bx bx-log-out-circle'></i><span>Déconnexion</span>
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>