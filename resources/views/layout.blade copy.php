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

    <nav class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <x-logo />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header">
                    <a class="navbar-brand" href="/">
                        <x-logo />
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">

                    <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->photo_url)
                                <img style="height: 20px;" src="{{ asset(Auth::user()->photo_url) }}" alt="" class="rounded-circle">
                                @else
                                <i class="bi bi-person"></i>
                                @endif
                                {{ Auth::user()->name }}
                                @if (Auth::user()->isAdmin())
                                <span class="text-warning"> (ADMIN)</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Log out</a></li>
                                <li><a class="dropdown-item" href="{{ route('users.show', auth()->user()->id) }}">My profile</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>

                        @if (Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Menu ADMIN
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.index') }}">Users</a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        @endauth

                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Log in</a>
                        </li>
                        @endguest
                    </ul>

                    <span class="navbar-text">
                        <strong>BETA BETA BETA BETA</strong>
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-shrink-0 p-3">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <footer class="footer mt-auto py-1">
        <div class="container">
            <span>
                <a href="{{ route('the-author') }}">&copy; Dom</a> |
                <a href="#">Contact the author</a> |
                <a href="#">Terms of service</a>
            </span>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @yield('extra_js')
</body>

</html>