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
        <main class="bg-light min-vh-100" style="background-image: url(); background-size:cover; background-attachment: fixed;">    
            {{-- banner --}}
            <div class="container-fluid p-0">
                <img src="https://lh3.googleusercontent.com/u/0/d/1RSLtvEv1UIqr10TJdJ4mQgIPBO7NqwQz=w2000-h338-iv2" class="w-100">
            </div>
            
            <nav class="container-fluid navbar navbar-expand-md bg-success shadow-sm">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="row collapse navbar-collapse mx-auto" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav text-white justify-content-evenly">
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
                                                    <ul class="dropdown-menu" aria-labelledby="submenu{{ $menu->id }}">
                                                        @foreach ($subMenu->subSubMenus as $subSubMenu)
                                                            @if ($subSubMenu->type === 'page')
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('page.show', $subSubMenu->id) }}">
                                                                        {{ $subSubMenu->sub_sub_menu }}
                                                                    </a>
                                                                </li>
                                                            @elseif ($subSubMenu->type === 'dropdown')
                                                                <li class="dropdown-submenu dropright">
                                                                    <a class="dropdown-item dropdown-toggle" href="#">
                                                                        {{ $subSubMenu->sub_sub_menu }}
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        @foreach ($subSubMenu->subSubSubMenus as $subSubSubMenu)
                                                                            <li>
                                                                                <a class="dropdown-item" href="{{ route('page.show', $subSubSubMenu->id) }}">
                                                                                    {{ $subSubSubMenu->sub_sub_sub_menu }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{url('/')}}">
                                    {{__("BERITA")}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{url('/')}}">
                                    {{__("UNDUH")}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="{{route('home')}}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="search" placeholder="Cari Berita...">
                                        <button class="btn btn-secondary" type="submit"><i class="bi bi-search"></i></button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            @yield('content')
        </main>

        @include('layouts.footer')
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
            <!-- Chat Window -->
            <div id="chatWindow" class="card shadow-lg border-0 d-none mb-5 rounded" style="width: 300px;position: absolute; bottom: 90px; right: 16px;">
                <div class="card-header d-flex align-items-center bg-success text-white">
                    <div class="me-3">
                        <img src="/img/user.png" 
                             alt="John Doe" 
                             class="rounded-circle" 
                             width="50" 
                             height="50">
                    </div>
                    <div>
                        <h5 class="mb-0">Admin Website</h5>
                        <small>Online</small>
                    </div>
                    <button id="closeChatBtn" type="button" class="btn-close btn-close-white ms-auto" aria-label="Close"></button>
                </div>
                <div class="card-body" style="background-image: url(/img/wa-bg.jpg);background-size:cover">
                    <div class="mb-3 text-muted small text-center">
                        <span class="bg-light rounded px-2">{{Carbon\Carbon::now()->translatedFormat('H:i T')}}</span>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-light rounded p-2">
                                <p class="mb-0">Halo 👋</p>
                                <p class="mb-0">Apakah ada yang bisa dibantu?</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="https://wa.me/85812345678" class="btn btn-success d-inline-flex align-items-center gap-2 mb-3" >
                            <i class="bi bi-whatsapp fs-4"></i>
                            Chat on WhatsApp
                            </a>
                    </div>
                </div>
            </div>
        
            <!-- Scroll to Top Button -->
            <button id="scrollTopBtn" class="btn-lg btn btn-primary d-none rounded-circle" 
                    onclick="scrollToTop()" title="Go to top">
                <i class="bi bi-arrow-up fs-4 text-white"></i>
            </button>
            
            <!-- Toggle Chat Button -->
            <button id="toggleChatBtn" class="btn-lg btn btn-success rounded-circle shadow-lg" style="position: absolute; bottom: 75px; right: 16px;">
                <i class="bi bi-whatsapp fs-4 text-white"></i>
            </button>
        
        </div>        
          
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
            //livetoast
            const toastLiveExample = document.getElementById('liveToast');
            if (toastLiveExample) {
                const toast = new bootstrap.Toast(toastLiveExample);
                toast.show();
            }
            //scrollontop
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

                // Handle submenu toggle logic
                const subMenuItems = document.querySelectorAll('.dropdown-submenu .dropdown-toggle');

                subMenuItems.forEach(function (item) {
                    item.addEventListener('click', function (e) {
                        e.preventDefault(); // Prevent default action

                        const submenu = item.nextElementSibling; // Get the submenu
                        const isCurrentlyOpen = submenu.classList.contains('show'); // Check if it's open

                        // Close unrelated submenus
                        document.querySelectorAll('.dropdown-menu.show').forEach(function (openMenu) {
                            if (openMenu !== submenu && !openMenu.contains(item)) {
                                openMenu.classList.remove('show');
                            }
                        });

                        // Toggle the clicked submenu
                        if (!isCurrentlyOpen) {
                            submenu.classList.add('show'); // Open it
                            currentOpenSubmenu = submenu; // Update the current open submenu
                        } else {
                            submenu.classList.remove('show'); // Close it
                            currentOpenSubmenu = null; // Reset the open submenu
                        }
                    });
                });

                // Prevent clicking inside a submenu from closing the parent dropdown
                const dropdownItems = document.querySelectorAll('.dropdown-menu');
                dropdownItems.forEach(function (menu) {
                    menu.addEventListener('click', function (e) {
                        e.stopPropagation(); // Prevent propagation to parent menus
                    });
                });
            });
            // chat visibility
            const toggleChatBtn = document.getElementById('toggleChatBtn');
            const chatWindow = document.getElementById('chatWindow');
            const closeChatBtn = document.getElementById('closeChatBtn');

            // Toggle chat window visibility
            toggleChatBtn.addEventListener('click', () => {
                chatWindow.classList.toggle('d-none');
            });

            // Close chat window
            closeChatBtn.addEventListener('click', () => {
                chatWindow.classList.add('d-none');
            });
        </script>
       
    </div>
</body>
</html>
