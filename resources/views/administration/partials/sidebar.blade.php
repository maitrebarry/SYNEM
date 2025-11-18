<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="branding">
            <img src="{{ asset('template-admin/assets/images/logo2_atelierCouture.jpeg') }}" class="logo-icon" alt="SYNEM Logo">
            <h6 class="logo-text synem-logo">SYNEM ADMIN</h6>
        </div>
        <div class="toggle-icon ms-auto">
            <i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <!-- Tableau de bord -->
        <li class="{{ request()->routeIs('administration.tableau-de-bord') ? 'mm-active' : '' }}">
            <a href="{{ route('administration.tableau-de-bord') }}" class="{{ request()->routeIs('administration.tableau-de-bord') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                <div class="menu-title">Tableau de bord</div>
            </a>
        </li>

        <!-- Publications et Actualités -->
        <li class="{{ request()->routeIs('administration.publications.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow {{ request()->routeIs('administration.publications.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-news'></i></div>
                <div class="menu-title">Publications</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('administration.publications.liste') }}"><i class="bx bx-right-arrow-alt"></i>Toutes les publications</a>
                </li>
                <li>
                    <a href="{{ route('administration.publications.creer') }}"><i class="bx bx-right-arrow-alt"></i>Créer une publication</a>
                </li>
                <li>
                    <a href="{{ route('administration.publications.categories') }}"><i class="bx bx-right-arrow-alt"></i>Catégories</a>
                </li>
                <li>
                    <a href="{{ route('administration.publications.carousels') }}"><i class="bx bx-right-arrow-alt"></i>Carousels d'accueil</a>
                </li>
            </ul>
        </li>

        <!-- Documents Administratifs -->
        <li class="{{ request()->routeIs('administration.documents.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow {{ request()->routeIs('administration.documents.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-folder'></i></div>
                <div class="menu-title">Documents</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('administration.documents.liste') }}"><i class="bx bx-right-arrow-alt"></i>Tous les documents</a>
                </li>
                <li>
                    <a href="{{ route('administration.documents.ajouter') }}"><i class="bx bx-right-arrow-alt"></i>Ajouter un document</a>
                </li>
                <li>
                    <a href="{{ route('administration.documents.categories') }}"><i class="bx bx-right-arrow-alt"></i>Catégories</a>
                </li>
                <li>
                    <a href="{{ route('administration.documents.statistiques') }}"><i class="bx bx-right-arrow-alt"></i>Statistiques</a>
                </li>
            </ul>
        </li>

        <!-- Pages Statiques -->
        <li class="{{ request()->routeIs('administration.pages.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow {{ request()->routeIs('administration.pages.accueil.*') || request()->routeIs('administration.pages.a-propos.*') || request()->routeIs('administration.pages.mission.*') || request()->routeIs('administration.pages.historique.*') || request()->routeIs('administration.pages.contact.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-globe'></i></div>
                <div class="menu-title">Pages du site</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('administration.pages.accueil.edit') }}" class="{{ request()->routeIs('administration.pages.accueil.*') ? 'mm-active' : '' }}"><i class="bx bx-right-arrow-alt"></i>Page d'accueil</a>
                </li>
                <li>
                    <a href="{{ route('administration.pages.a-propos.edit') }}" class="{{ request()->routeIs('administration.pages.a-propos.*') ? 'mm-active' : '' }}"><i class="bx bx-right-arrow-alt"></i>À propos</a>
                </li>
                <li>
                    <a href="{{ route('administration.pages.mission.edit') }}" class="{{ request()->routeIs('administration.pages.mission.*') ? 'mm-active' : '' }}"><i class="bx bx-right-arrow-alt"></i>Notre mission</a>
                </li>
                <li>
                    <a href="{{ route('administration.pages.historique.edit') }}" class="{{ request()->routeIs('administration.pages.historique.*') ? 'mm-active' : '' }}"><i class="bx bx-right-arrow-alt"></i>Historique</a>
                </li>
                <li>
                    <a href="{{ route('administration.pages.contact.edit') }}" class="{{ request()->routeIs('administration.pages.contact.*') ? 'mm-active' : '' }}"><i class="bx bx-right-arrow-alt"></i>Contact</a>
                </li>
            </ul>
        </li>

        <!-- Médiathèque -->
        <li class="{{ request()->routeIs('administration.mediatheque.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow {{ request()->routeIs('administration.mediatheque.*') ? 'mm-active' : '' }}">
                <div class="parent-icon"><i class='bx bx-photo-album'></i></div>
                <div class="menu-title">Médiathèque</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('administration.mediatheque.images') }}"><i class="bx bx-right-arrow-alt"></i>Images</a>
                </li>
                <li>
                    <a href="{{ route('administration.mediatheque.documents') }}"><i class="bx bx-right-arrow-alt"></i>Documents</a>
                </li>
                <li>
                    <a href="{{ route('administration.mediatheque.upload') }}"><i class="bx bx-right-arrow-alt"></i>Upload</a>
                </li>
            </ul>
        </li>

        <!-- Paramètres essentiels -->
      
        <li>
            <a href="{{ route('administration.parametres.index') }}">
                <div class="parent-icon"><i class='bx bx-cog'></i></div>
                <div class="menu-title">Paramètres</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>