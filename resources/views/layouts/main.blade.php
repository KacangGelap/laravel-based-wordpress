<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="/css/bootstrap.css">
    <script src="/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
                /* Style for the dropright submenu */
        .dropdown-submenu {
            position: relative;
        }

                /* Make sure submenu appears correctly */
        .dropdown-submenu .dropdown-menu {
            left: 100%;
            top: 0;
            margin-top: -1px;
        }
    </style>
</head>
<body>
    <div id="app">
        <main class="py-4 bg-dark min-vh-100" style="background-image: url(/img/background-app.jpeg); background-size:cover; background-attachment: fixed;">    
            <nav class="container navbar navbar-expand-md bg-success shadow-sm">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <div class="row">
                            <div class="justify-content-center">
                                <ul class="navbar-nav text-decoration-underline text-white">
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{url('/')}}">
                                            {{__("BERANDA")}}
                                        </a>
                                    </li>
                                    @foreach ($menus as $menu)
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle text-white" href="#" id="menu{{ $menu->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $menu->menu }}
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="menu{{ $menu->id }}">
                                                @foreach ($menu->subMenus as $subMenu)
                                                    @if ($subMenu->type === 'page')
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('page.show', $subMenu->id) }}">
                                                                {{ $subMenu->sub_menu }}
                                                            </a>
                                                        </li>
                                                    @elseif ($subMenu->type === 'dropdown')
                                                        <li class="dropdown-submenu dropright">
                                                            <a class="dropdown-item dropdown-toggle" href="#">
                                                                {{ $subMenu->sub_menu }}
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                @foreach ($subMenu->subSubMenus as $subSubMenu)
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('page.show', $subSubMenu->id) }}">
                                                                            {{ $subSubMenu->sub_sub_menu }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                    
                                <ul class="navbar-nav">
                                    <form action="{{route('home')}}" method="post">
                                        @csrf
                                        <input type="text" name="search" placeholder="Cari Berita...">
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            @yield('content')
        </main>
        <button id="scrollTopBtn" class="btn-lg btn btn-primary position-fixed bottom-0 end-0 m-3 me-5 d-none rounded-circle" onclick="scrollToTop()" title="Go to top">
            <i class="bi-arrow-up"></i>
        </button>          
        @if (session('sukses'))
        <div class="toast-container position-fixed bottom-0 p-3" >
            <div id="liveToast" class="toast show align-items-center bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        Success
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-white text-bold">
                        {{ session('sukses') }}
                    </div>
                    
            </div>
        </div>
        @endif
        @if (session('gagal'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast show align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        Failed
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body bg-danger text-white text-bold">
                        {{ session('gagal') }}
                    </div>
                    
            </div>
        </div>
        @endif
        <script>
            const toastLiveExample = document.getElementById('liveToast');
            if (toastLiveExample) {
                const toast = new bootstrap.Toast(toastLiveExample);
                toast.show();
            }
            window.onscroll = function () {
            const scrollTopBtn = document.getElementById("scrollTopBtn");
            if (document.documentElement.scrollTop > 100) {
                scrollTopBtn.classList.remove("d-none");
            } else {
                scrollTopBtn.classList.add("d-none");
            }
            };

            function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
            }

            //dropdowns
            document.addEventListener('DOMContentLoaded', function () {
                let currentOpenSubmenu = null; // Variable to track the currently open submenu
                
                // Prevent outer dropdown from closing when clicking on submenu
                const dropdownItems = document.querySelectorAll('.dropdown-submenu');

                dropdownItems.forEach(function (item) {
                    item.addEventListener('click', function (e) {
                        e.stopPropagation(); // Prevent click from propagating to parent dropdown
                    });
                });

                // Handle submenu toggle logic
                const subMenuItems = document.querySelectorAll('.dropdown-submenu .dropdown-toggle');
                
                subMenuItems.forEach(function (item) {
                    item.addEventListener('click', function (e) {
                        e.preventDefault(); // Prevent the default action of closing the dropdown
                        
                        const submenu = item.nextElementSibling; // Get the submenu
                        const isCurrentlyOpen = submenu.classList.contains('show'); // Check if it is already open
                        
                        // Close the currently open submenu (if any)
                        if (currentOpenSubmenu && currentOpenSubmenu !== submenu) {
                            currentOpenSubmenu.classList.remove('show');
                        }
                        
                        // Toggle the clicked submenu
                        if (!isCurrentlyOpen) {
                            submenu.classList.add('show'); // Open the submenu if it wasn't open
                            currentOpenSubmenu = submenu; // Update the current open submenu
                        } else {
                            currentOpenSubmenu = null; // No submenu open
                        }
                    });
                });
            });

        </script>
    </div>
</body>
</html>
