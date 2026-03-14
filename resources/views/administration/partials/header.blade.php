@php
use Illuminate\Support\Str;
$notificationsList = $militantNotifications ?? collect();
$notificationCount = $pendingMilitantMessagesCount ?? 0;
@endphp

<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
            
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ url('/') }}" target="_blank" rel="noopener" title="Voir le site">
                            <i class='bx bx-globe'></i>
                            <span class="d-none d-md-inline ms-1">Voir le site</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="alert-count" id="notification-count">{{ $notificationCount }}</span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-clear ms-auto">
                                        <a href="{{ route('administration.pages.militant-messages.index') }}" class="text-decoration-none">Tout marquer comme lu</a>
                                    </p>
                                </div>
                            </a>
                            <div class="header-notifications-list" id="notifications-list">
                                @if($notificationsList->isEmpty())
                                    <div class="text-center py-3 text-muted small">Aucune nouvelle question.</div>
                                @else
                                    @foreach($notificationsList as $notification)
                                        <a class="dropdown-item" href="{{ route('administration.pages.militant-messages.index') }}">
                                            <div class="d-flex align-items-start gap-2">
                                                <i class="fas fa-question-circle text-warning fs-5"></i>
                                                <div class="flex-grow-1 overflow-hidden" style="min-width: 0;">
                                                    <p class="mb-1 text-truncate" style="max-width: 220px;">{{ Str::limit($notification->question, 80) }}</p>
                                                    <small class="text-muted d-block text-truncate" style="max-width: 220px;">{{ $notification->militant?->name ?? 'Militant' }} • {{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                            <a href="{{ route('administration.pages.militant-messages.index') }}">
                                <div class="text-center msg-footer">Voir toutes les notifications</div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Menu utilisateur -->
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::check() && Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('template-admin/assets/images/default-user.jpg') }}" class="user-img" alt="user avatar" id="headerUserImg">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ Auth::check() ? Auth::user()->name : 'Admin SYNEM' }}</p>
                        <p class="designattion mb-0">Administrateur</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @if(Auth::check())
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bx bx-user"></i><span>Mon Profil</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('administration.parametres.index') }}">
                            <i class="bx bx-cog"></i><span>Paramètres</span>
                        </a>
                    </li>
                    <li><div class="dropdown-divider mb-0"></div></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <button type="submit" class="dropdown-item btn-logout">
                                <i class='bx bx-log-out-circle'></i><span>Déconnexion</span>
                            </button>
                        </form>
                    </li>
                    @else
                    <li>
                        <a class="dropdown-item" href="{{ route('login') }}">
                            <i class="bx bx-log-in-circle"></i><span>Connexion</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>