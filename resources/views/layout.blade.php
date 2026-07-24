<!doctype html>
<html lang="{{ app()->getLocale() }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="No backend? No problem. Get a free sandbox API key to practice API integration, test front-end apps, and master Postman in a resettable environment.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="/img/icon.png" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('extra_css')
</head>

<body class="d-flex flex-column h-100">

    <!-- BARRE SUPÉRIEURE -->
    <nav class="navbar navbar-dark shadow-sm py-0" style="height: 40px; background-color: var(--nav-bg);">
        <div class="container-fluid d-flex align-items-center h-100">
            <button class="btn btn-sm btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <i class="bi bi-list"></i> Menu
            </button>

            <span class="navbar-brand mb-0 h6 text-white-50 py-0">Lycée Bali Bala</span>
            <span class="navbar-brand mb-0 h6 text-white-50 py-0">Année scolaire 2026/2027</span>
        </div>
    </nav>


    <!-- CONTENEUR PRINCIPAL -->
    <div class="d-flex main-wrapper">
        <!-- LE MENU VERTICAL COMPACT -->
        <div class="offcanvas-lg offcanvas-start custom-sidebar text-dark h-100 d-flex flex-column p-2" tabindex="-1" id="sidebarMenu" style="min-width: 100px; max-width: 240px;">

            <div class="offcanvas-header border-bottom d-lg-none">
                <h5 class="offcanvas-title fw-bold" style="color: var(--nav-bg);" id="sidebarMenuLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
            </div>

            <a href="{{ route('home') }}" class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2">
                @if(request()->routeIs('home'))
                <strong><i class="bi bi-house me-2"></i>Accueil</strong>
                @else
                <i class="bi bi-house me-2"></i>Accueil
                @endif
            </a>
            @guest
            <a href="{{ route('login') }}" class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2">
                @if(request()->routeIs('login'))
                <strong><i class="bi bi-box-arrow-in-left me-2"></i>Connexion</strong>
                @else
                <i class="bi bi-box-arrow-in-left me-2"></i>Connexion
                @endif
            </a>
            @endguest

            @auth
            <x-vertical-menu />
            @endauth


            {{--
            <!-- BLOC COMPTE UTILISATEUR -->
            <div class="mt-auto p-3 border-bottom bg-light-subtle d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center min-w-0">
                    <div class="avatar-initials bg-primary text-white me-2 flex-shrink-0">
                        JD
                    </div>
                    <div class="min-w-0">
                        <p class="mb-0 fw-bold text-dark text-truncate" style="font-size: 0.85rem;">John Doe</p>
                        <span class="text-secondary d-block text-truncate" style="font-size: 0.75rem;">Administrateur</span>
                    </div>
                </div>
                <a href="#" class="text-secondary hover-primary ps-2" title="Déconnexion">
                    <i class="bi bi-box-arrow-right fs-5 text-danger"></i>
                </a>
            </div>

            <!-- Zone des liens (avec overflow-y: auto au cas où la liste s'allonge trop sur petit écran) -->
            <div class="offcanvas-body p-0 flex-grow-1 overflow-y-auto">
                <div class="list-group list-group-flush w-100">

                    <!-- Option Simple 1 -->
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2">
            <i class="bi bi-house-door-fill text-secondary me-2"></i> Accueil
            </a>
            <a href="{{ route('login') }}" class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2">
                <i class="bi bi-house-door-fill text-secondary me-2"></i> Connexion
            </a>
            <!-- Menu Dynamique 1 -->
            <div>
                <button class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2 d-flex align-items-center btn-toggle"
                    data-bs-toggle="collapse" data-bs-target="#subProjets" aria-expanded="true">
                    <i class="bi bi-folder-fill text-warning me-2"></i> Mes Projets
                </button>
                <div class="collapse bg-white show" id="subProjets">
                    <div class="list-group list-group-flush ps-4">
                        <a href="#" class="list-group-item list-group-item-action bg-transparent text-secondary border-0 py-1 small">Projet Web</a>
                        <a href="#" class="list-group-item list-group-item-action bg-transparent text-secondary border-0 py-1 small">Projet Mobile</a>
                    </div>
                </div>
            </div>
            <!-- NOUVEAU : Menu Dynamique 2 -->
            <div>
                <button class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2 d-flex align-items-center btn-toggle"
                    data-bs-toggle="collapse" data-bs-target="#subRapports" aria-expanded="true">
                    <i class="bi bi-bar-chart-line-fill text-success me-2"></i> Rapports
                </button>
                <div class="collapse bg-white show" id="subRapports">
                    <div class="list-group list-group-flush ps-4">
                        <a href="#" class="list-group-item list-group-item-action bg-transparent text-secondary border-0 py-1 small">Ventes</a>
                        <a href="#" class="list-group-item list-group-item-action bg-transparent text-secondary border-0 py-1 small">Statistiques</a>
                    </div>
                </div>
            </div>
            <!-- NOUVEAU : Menu Dynamique 3 (Fermé) -->
            <div>
                <button class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2 d-flex align-items-center btn-toggle"
                    data-bs-toggle="collapse" data-bs-target="#subOutils" aria-expanded="true">
                    <i class="bi bi-wrench-adjustable-circle-fill text-info me-2"></i> Outils
                </button>
                <div class="collapse bg-white show" id="subOutils">
                    <div class="list-group list-group-flush ps-4">
                        <a href="#" class="list-group-item list-group-item-action bg-transparent text-secondary border-0 py-1 small">Import / Export</a>
                        <a href="#" class="list-group-item list-group-item-action bg-transparent text-secondary border-0 py-1 small">Logs système</a>
                    </div>
                </div>
            </div>
            <!-- Menu Dynamique 4 (Fermé) -->
            <div>
                <button class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2 d-flex align-items-center btn-toggle"
                    data-bs-toggle="collapse" data-bs-target="#subParametres" aria-expanded="true">
                    <i class="bi bi-gear-fill text-secondary me-2"></i> Paramètres
                </button>
                <div class="collapse bg-white show" id="subParametres">
                    <div class="list-group list-group-flush ps-4">
                        <a href="#" class="list-group-item list-group-item-action bg-transparent text-secondary border-0 py-1 small">Profil</a>
                        <a href="#" class="list-group-item list-group-item-action bg-transparent text-secondary border-0 py-1 small">Sécurité</a>
                    </div>
                </div>
            </div>
            <!-- Option Simple 2 -->
            <a href="#" class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2">
                <i class="bi bi-envelope-fill text-secondary me-2"></i> Contact
            </a>
        </div>
    </div>
    --}}
    </div>

    <!-- LE CONTENU DE LA PAGE -->
    <div class="flex-grow-1 p-2 content-area">
        @yield('content')
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @yield('extra_js')
</body>

</html>