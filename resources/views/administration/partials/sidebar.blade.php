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
        <li>
            <a href="{{ route('administration.tableau-de-bord') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                <div class="menu-title">Tableau de bord</div>
            </a>
        </li>

        <!-- Publications -->
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-news'></i></div>
                <div class="menu-title">Publications</div>
            </a>
            <ul>
                <li>
                    <a href="#"><i class="bx bx-right-arrow-alt"></i>Liste des publications</a>
                </li>
                <li>
                    <a href="#"><i class="bx bx-right-arrow-alt"></i>Nouvelle publication</a>
                </li>
                <li>
                    <a href="#"><i class="bx bx-right-arrow-alt"></i>Catégories</a>
                </li>
            </ul>
        </li>

        <!-- Documents -->
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-folder'></i></div>
                <div class="menu-title">Documents</div>
            </a>
            <ul>
                <li>
                    <a href="#"><i class="bx bx-right-arrow-alt"></i>Gestion des documents</a>
                </li>
                <li>
                    <a href="#"><i class="bx bx-right-arrow-alt"></i>Ajouter un document</a>
                </li>
                <li>
                    <a href="#"><i class="bx bx-right-arrow-alt"></i>Catégories documents</a>
                </li>
            </ul>
        </li>

        <!-- Événements -->
        <li>
            <a href="#">
                <div class="parent-icon"><i class='bx bx-calendar-event'></i></div>
                <div class="menu-title">Événements</div>
            </a>
        </li>

        <!-- Galerie -->
        <li>
            <a href="#">
                <div class="parent-icon"><i class='bx bx-photo-album'></i></div>
                <div class="menu-title">Médiathèque</div>
            </a>
        </li>

        <!-- Membres -->
        <li>
            <a href="#">
                <div class="parent-icon"><i class='bx bx-user'></i></div>
                <div class="menu-title">Gestion des membres</div>
            </a>
        </li>

        <!-- Paramètres -->
        <li>
            <a href="#">
                <div class="parent-icon"><i class='bx bx-cog'></i></div>
                <div class="menu-title">Paramètres</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>