<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="branding">
            <!-- <img src="{{ asset('template-admin/assets/images/syneklogo.jpeg') }}" class="logo-icon" alt="SYNEM Logo"> -->
            <h6 class="logo-text synem-logo">SYNEM ADMIN</h6>
        </div>
        <div class="toggle-icon ms-auto">
            <i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation: conserver uniquement les pages du site comme modules top-level + Paramètres -->
    <ul class="metismenu" id="menu">
        <!-- Tableau de bord -->
        <li class="{{ request()->routeIs('administration.tableau-de-bord') ? 'mm-active' : '' }}">
            <a href="{{ route('administration.tableau-de-bord') }}" class="{{ request()->routeIs('administration.tableau-de-bord') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-grid-alt'></i></div>
                <div class="menu-title">Tableau de bord</div>
            </a>
        </li>

        <!-- Page d'accueil -->
        <li class="{{ request()->routeIs('administration.pages.accueil.*') ? 'mm-active' : '' }}">
            <a href="{{ route('administration.pages.accueil.edit') }}" class="{{ request()->routeIs('administration.pages.accueil.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                <div class="menu-title">Page d'accueil</div>
            </a>
        </li>

        <!-- À propos -->
        <li class="{{ request()->routeIs('administration.pages.a-propos.*') ? 'mm-active' : '' }}">
            <a href="{{ route('administration.pages.a-propos.edit') }}" class="{{ request()->routeIs('administration.pages.a-propos.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-user'></i></div>
                <div class="menu-title">À propos</div>
            </a>
        </li>

        <!-- Notre mission -->
        <li class="{{ request()->routeIs('administration.pages.mission.*') ? 'mm-active' : '' }}">
            <a href="{{ route('administration.pages.mission.edit') }}" class="{{ request()->routeIs('administration.pages.mission.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-bullseye'></i></div>
                <div class="menu-title">Notre mission</div>
            </a>
        </li>

        <!-- Historique -->
        <li class="{{ request()->routeIs('administration.pages.historique.*') ? 'mm-active' : '' }}">
            <a href="{{ route('administration.pages.historique.edit') }}" class="{{ request()->routeIs('administration.pages.historique.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-history'></i></div>
                <div class="menu-title">Historique</div>
            </a>
        </li>

        <!-- Contact -->
        <li class="{{ request()->routeIs('administration.pages.contact.*') ? 'mm-active' : '' }}">
            <a href="{{ route('administration.pages.contact.edit') }}" class="{{ request()->routeIs('administration.pages.contact.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-envelope'></i></div>
                <div class="menu-title">Contact</div>
            </a>
        </li>

        <!-- Militants -->
        <li class="{{ request()->routeIs('administration.pages.militants.*') ? 'mm-active' : '' }}">
            <a href="{{ route('administration.pages.militants.index') }}" class="{{ request()->routeIs('administration.pages.militants.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-group'></i></div>
                <div class="menu-title">Militants</div>
            </a>
        </li>

        <!-- Paramètres essentiels -->
        <li class="{{ request()->routeIs('administration.parametres.*') ? 'mm-active' : '' }}">
            <a href="{{ route('administration.parametres.index') }}" class="{{ request()->routeIs('administration.parametres.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-cog'></i></div>
                <div class="menu-title">Paramètres</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>