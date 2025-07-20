<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="{{app('metadata')['title']}}" />
    <meta property="og:description" content="{{app('metadata')['description']}}" />
    <meta property="og:image" content="{{app('metadata')['image']}}" />
    <meta property="og:url" content="{{app('metadata')['url']}}" />
    <meta property="og:type" content="{{app('metadata')['type']}}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/disability-helper.css">
    <script src="/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .img-hover-container {
            position: relative;
            overflow: hidden;
        }

        .img-hover-container img {
            display: block;
            width: 100%;
            height: 300px;
            object-fit: cover;
            object-position: center;
        }

        .img-hover-overlay {
            position: absolute;
            bottom: -100%; /* sembunyi di bawah */
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* overlay hitam transparan */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 10px;
            transition: all 0.4s ease-in-out;
        }

        .img-hover-container:hover .img-hover-overlay {
            bottom: 0; /* geser ke atas saat hover */
        }
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
        @media (max-width: 576px) {
        #chatWindow,
        #toggleChatBtn {
            bottom: 70px !important;
            right: 10px !important;
        }

        #scrollTopBtn {
            bottom:20px !important;
            /* display: none !important; */
        }
    }
    </style>
</head>
<body class="">
    <div id="app">
        <main class="min-vh-100" style="background-image: url(); background-size:cover; background-attachment: fixed;">    
            {{-- banner --}}
            <div class="container-fluid p-0">
                @if(isset($banner))
                <img src="{{asset('storage/'.$banner->media)}}" class="w-100"  style="aspect-ratio:10/1.5">
                @endif
            </div>
            
            <nav class="container-fluid navbar navbar-expand-md bg-success shadow-sm">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="row collapse navbar-collapse mx-auto" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav text-white justify-content-evenly fs-6">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{url('/')}}" style="font-size: 12px">
                                    {{__("BERANDA")}}
                                </a>
                            </li>
                            @foreach ($menus as $menu)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-white h-100" href="#" id="menu{{ $menu->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 12px">
                                        {{ $menu->menu }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="menu{{ $menu->id }}">
                                        @foreach ($menu->subMenus as $subMenu)
                                            @if ($subMenu->type === 'page' || $subMenu->type === 'id.pdupt')
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('page.show', ['id'=>$subMenu->halaman->first()->id]) }}">
                                                        {{ $subMenu->sub_menu }}
                                                    </a>
                                                </li>
                                            @elseif ($subMenu->type === 'link')
                                            <li>
                                                <a class="dropdown-item" href="{{$subMenu->filetype == 'video' ? 'https://youtu.be/'.$subMenu->link : $subMenu->link}}" target="_blank">
                                                    {{ $subMenu->sub_menu }}
                                                    <i class="bi-box-arrow-up-right"></i>
                                                </a>
                                            </li>
                                            @elseif ($subMenu->type === 'dropdown')
                                                <li class="dropdown-submenu dropright">
                                                    <a class="dropdown-item dropdown-toggle" href="#">
                                                        {{ $subMenu->sub_menu }}
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="submenu{{ $menu->id }}">
                                                        @foreach ($subMenu->subSubMenus as $subSubMenu)
                                                            @if ($subSubMenu->type === 'page' || $subSubMenu->type === 'id.pdupt')
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('page.show', ['id'=>$subSubMenu->halaman->first()->id]) }}">
                                                                        {{ $subSubMenu->sub_sub_menu }}
                                                                    </a>
                                                                </li>
                                                            @elseif ($subSubMenu->type === 'link')
                                                            <li>
                                                                <a class="dropdown-item" href="{{$subSubMenu->filetype == 'video' ? 'https://youtu.be/'.$subSubMenu->link : $subSubMenu->link}}" target="_blank">
                                                                    {{ $subSubMenu->sub_sub_menu }}
                                                                    <i class="bi-box-arrow-up-right"></i>
                                                                </a>
                                                            </li>
                                                            @elseif ($subSubMenu->type === 'dropdown')
                                                                <li class="dropdown-submenu dropright">
                                                                    <a class="dropdown-item dropdown-toggle" href="#">
                                                                        {{ $subSubMenu->sub_sub_menu }}
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        @foreach ($subSubMenu->subSubSubMenus as $subSubSubMenu)
                                                                            @if($subSubSubMenu->type === 'page' || $subSubSubMenu->type === 'id.pdupt')
                                                                            <li>
                                                                                <a class="dropdown-item" href="{{ route('page.show', ['id'=>$subSubSubMenu->halaman->first()->id]) }}">
                                                                                    {{ $subSubSubMenu->sub_sub_sub_menu }}
                                                                                </a>
                                                                            </li>
                                                                            @elseif ($subSubSubMenu->type === 'link')
                                                                            <li>
                                                                                <a class="dropdown-item" href="{{$subSubSubMenu->filetype == 'video' ? 'https://youtu.be/'.$subSubSubMenu->link : $subSubSubMenu->link}}" target="_blank">
                                                                                    {{ $subSubSubMenu->sub_sub_sub_menu }}
                                                                                    <i class="bi-box-arrow-up-right"></i>
                                                                                </a>
                                                                            </li>
                                                                            @elseif ($subSubSubMenu->type === 'dropdown')
                                                                            <li class="dropdown-submenu dropright">
                                                                                <a class="dropdown-item dropdown-toggle" href="#">
                                                                                    {{ $subSubSubMenu->sub_sub_sub_menu }}
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                        @foreach ($subSubSubMenu->subSubSubSubMenus as $subSubSubSubMenu)
                                                                                            @if($subSubSubSubMenu->type === 'page' || $subSubSubSubMenu->type === 'id.pdupt')
                                                                                            <li>
                                                                                                <a class="dropdown-item" href="{{ route('page.show', ['id'=>$subSubSubSubMenu->halaman->first()->id]) }}">
                                                                                                    {{ $subSubSubSubMenu->sub_sub_sub_sub_menu }}
                                                                                                </a>
                                                                                            </li>
                                                                                            @elseif ($subSubSubSubMenu->type === 'link')
                                                                                            <li>
                                                                                                <a class="dropdown-item" href="{{$subSubSubSubMenu->filetype == 'video' ? 'https://youtu.be/'.$subSubSubSubMenu->link : $subSubSubMenu->link}}" target="_blank">
                                                                                                    {{ $subSubSubSubMenu->sub_sub_sub_sub_menu }}
                                                                                                    <i class="bi-box-arrow-up-right"></i>
                                                                                                </a>
                                                                                            </li>
                                                                                            @endif
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
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link text-white h-100" href="{{route('kalender.show')}}" style="font-size: 12px">
                                    {{__("AGENDA KEGIATAN")}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white  h-100" href="{{route('post.list')}}" style="font-size: 12px">
                                    {{__("BERITA")}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white h-100" href="{{route('galeri')}}" style="font-size: 12px">
                                    {{__("GALERI")}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white  h-100" href="{{route('unduh.show')}}" style="font-size: 12px">
                                    {{__("UNDUH")}}
                                </a>
                            </li>
                            @if($menu->count() == 7)<li class="nav-item col-md-1"> @elseif($menu->count() == 6) <li class="nav-item col-md-2"> @else <li class="nav-item"> @endif
                                <form action="{{route('post.search')}}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <input class="form-control @error('search') is-invalid @enderror" type="text" name="search" placeholder="Cari Berita...">
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
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;" id="floater">
            <!-- Chat Window -->
            <div id="chatWindow" class="card shadow-lg border-0 d-none mb-5 rounded" 
                style="width: 300px; position: absolute; bottom: 40px; right: 80px;">
                <div class="card-header d-flex align-items-center bg-success text-white">
                    <div class="me-3">
                        <img src="/img/user.png" alt="Admin" class="rounded-circle" width="50" height="50">
                    </div>
                    <div>
                        <h5 class="mb-0">Admin Website</h5>
                        <small id="statusText">Online</small>
                    </div>
                    <button id="closeChatBtn" type="button" class="btn-close btn-close-white ms-auto" aria-label="Close"></button>
                </div>
                <div class="card-body" style="background-image: url(/img/wa-bg.jpg); background-size: cover;">
                    <div class="mb-3 text-muted small text-center">
                        <span class="bg-light rounded px-2">
                            {{ Carbon\Carbon::now()->translatedFormat('H:i T') }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <div id="chatMessages" class="d-flex flex-column gap-2"></div>
                    </div>
                    <div class="text-center">
                        <a href="@if(isset($master->wa)) https://wa.me/62{{ intval($master->wa) }} @endif" 
                        class="btn btn-success d-inline-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-whatsapp fs-4"></i>
                            Chat on WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Toggle Chat Button -->
            <button id="toggleChatBtn" 
                    class="btn btn-success rounded-pill shadow-lg align-items-center px-3 py-2" 
                    style="position: absolute; bottom: 20px; right: 80px; width: 275px;">
                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle" id="chatBadge">
                    <span class="visually-hidden">New alerts</span>
                </span>
                <div class="d-flex justify-content-evenly align-items-center">
                    <i class="bi bi-whatsapp fs-5 text-white"></i>
                    <span class="text-white">Ada yang bisa kami bantu?</span>
                </div>
            </button>

            <!-- Scroll to Top Button (Hidden on Mobile) -->
            <button id="scrollTopBtn" class="position-absolute btn btn-primary d-none rounded-circle" 
                    onclick="scrollToTop()" title="Go to top" style="bottom:20px;right:10px">
                <i class="bi bi-arrow-up fs-4 text-white"></i>
            </button>
            <!-- Aksesibilitas Icon -->
<button class="btn btn-primary position-fixed bottom-0 m-3" id="accessibilityToggle" title="Menu Disabilitas" style="position: absolute; bottom: 20px; left:0px">
    <i class="bi-person-wheelchair fs-4"></i>
</button>

<!-- Panel Menu Aksesibilitas -->
<div id="accessibilityMenu" class="card position-fixed bottom-0 end-0 m-3 p-3 shadow-lg" style="width: 300px; display: none; z-index: 1050; left:0px">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Menu Disabilitas</h5>
        <button type="button" class="btn" aria-label="Close" id="accessibilityClose">X</button>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b class="bi-fonts"></b> <span id="btn-bigger-text" class="text-primary" role="button">Memperbesar Teks</span></li>
        <li class="list-group-item"><b class="bi-circle-half"></b> <span id="btn-contrast" class="text-primary" role="button">Warna Kontras</span></li>
        <li class="list-group-item"><b class="bi-link-45deg"></b> <span id="btn-highlight-links" class="text-primary" role="button">Menyorot Tautan</span></li>
        <li class="list-group-item"><b class="bi-distribute-horizontal"></b> <span id="btn-text-spacing" class="text-primary" role="button">Memperlebar Jarak Teks</span></li>
        <li class="list-group-item"><b class="bi-pause-btn"></b> <span id="btn-pause-animations" class="text-primary" role="button">Mematikan Animasi</span></li>
        <li class="list-group-item"><b class="bi-type"></b> <span id="btn-dyslexia" class="text-primary" role="button">Ramah Dyslexia</span></li>
        <li class="list-group-item"><b class="bi-cursor"></b> <span id="btn-cursor" class="text-primary" role="button">Cursor</span></li>
        <li class="list-group-item"><b class="bi-arrows-expand"></b> <span id="btn-line-height" class="text-primary" role="button">Mengatur Tinggi Teks</span></li>
        <li class="list-group-item"><b class="bi-justify-left"></b> <span onclick="toggleTextAlign()" class="text-primary" role="button">Menyelaraskan Teks</span></li>
        <li class="list-group-item"><b class="bi-volume-up"></b> <span id="btn-audio-description" class="text-primary" role="button">Membaca Teks</span></li>
    </ul>
</div>

        </div>
          
        @if (session('sukses'))
        <div class="toast-container position-fixed bottom-0 p-3" >
            <div id="liveToast" class="toast show align-items-center bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        Sukses
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
                        Gagal
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
            // Elemen-elemen DOM Uuntuk Floating Chat
            const toggleChatBtn = document.getElementById('toggleChatBtn');
            const chatWindow = document.getElementById('chatWindow');
            const closeChatBtn = document.getElementById('closeChatBtn');
            const chatBadge = document.getElementById('chatBadge');
            const chatMessages = document.getElementById('chatMessages');
            const typingIndicator = document.getElementById('typingIndicator');
            const statusText = document.getElementById('statusText');

            // Pesan yang akan ditampilkan
            const messages = [
                'Halo 👋',
                'Apakah ada yang bisa dibantu?'
            ];
            // Fungsi untuk menampilkan pesan dengan delay
            function displayMessages() {
                let index = 1;
                statusText.textContent = 'Mengetik...';

                const interval = setInterval(() => {
                    if (index < messages.length) {
                        const messageElement = document.createElement('div');
                        messageElement.classList.add('bg-light', 'rounded', 'p-2');
                        messageElement.setAttribute('data-chat', 'true');
                        messageElement.innerHTML = `<p class="mb-0">${messages[index-1]}</p>`;
                        chatMessages.appendChild(messageElement);
                        index++;
                    } else {
                        const messageElement = document.createElement('div');
                        messageElement.classList.add('bg-light', 'rounded', 'p-2');
                        messageElement.setAttribute('data-chat', 'true');
                        messageElement.innerHTML = `<p class="mb-0">${messages[index-1]}</p>`;
                        chatMessages.appendChild(messageElement);
                        statusText.textContent = 'Online';
                        clearInterval(interval);
                    }
                }, 1000);
            }
            // Fungsi untuk menghapus semua pesan
            function clearMessages() {
                const chatElements = chatMessages.querySelectorAll('[data-chat="true"]');
                chatElements.forEach(element => element.remove());
            }
            toggleChatBtn.addEventListener('click', () => {
                const isHidden = chatWindow.classList.toggle('d-none');
                if (!isHidden) {
                    displayMessages();
                }
                chatBadge.classList.toggle('d-none', !isHidden);
                clearMessages();
            });
            closeChatBtn.addEventListener('click', () => {
                chatWindow.classList.add('d-none');
                clearMessages();
            });

        document.addEventListener("DOMContentLoaded", function () {
            const body = document.body;
            const html = document.documentElement;

            const toggleAndPersist = (btnId, classTarget, className, useHtml = false) => {
                const element = useHtml ? html : body;
                const currentState = localStorage.getItem(className) === "true";

                if (currentState) {
                    element.classList.add(className);
                }

                const btn = document.getElementById(btnId);
                if (btn) {
                    btn.addEventListener("click", () => {
                        element.classList.toggle(className);
                        localStorage.setItem(className, element.classList.contains(className));
                    });
                }
            };

            toggleAndPersist('btn-bigger-text', html, 'bigger-text', true);
            toggleAndPersist('btn-contrast', body, 'high-contrast');
            toggleAndPersist('btn-highlight-links', body, 'highlight-links');
            toggleAndPersist('btn-text-spacing', body, 'text-spacing');
            toggleAndPersist('btn-pause-animations', body, 'pause-animations');
            toggleAndPersist('btn-dyslexia', body, 'dyslexia-mode');
            toggleAndPersist('btn-cursor', body, 'cursor-large');
            toggleAndPersist('btn-line-height', body, 'line-height');

            // ALIGNMENT toggle
            const alignments = ['text-align-start', 'text-align-center', 'text-align-end', 'text-align-justify'];
            let currentIndex = parseInt(localStorage.getItem('textAlignIndex')) || 0;
            if (alignments[currentIndex]) body.classList.add(alignments[currentIndex]);

            window.toggleTextAlign = function () {
                alignments.forEach(cls => body.classList.remove(cls));
                currentIndex = (currentIndex + 1) % alignments.length;
                const newClass = alignments[currentIndex];
                body.classList.add(newClass);
                localStorage.setItem('textAlignIndex', currentIndex);
            };

            // AUDIO DESCRIPTION toggle
            let isAudioDescriptionEnabled = localStorage.getItem('audioDescription') !== 'false';
            const btnAudio = document.getElementById("btn-audio-description");
            const speakText = (text) => {
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = "id-ID"; // preferensi bahasa Indonesia

                const voices = window.speechSynthesis.getVoices();
                const indoVoice = voices.find(v => v.lang === "id-ID");

                if (indoVoice) {
                    utterance.voice = indoVoice;
                } else {
                    console.warn("⚠️ Suara bahasa Indonesia tidak ditemukan. Menggunakan default.");
                }

                window.speechSynthesis.speak(utterance);
            };



            const hoverSpeak = (e) => {
                if (!isAudioDescriptionEnabled) return;
                const text = e.target.innerText.trim();
                if (text.length > 0) {
                    speakText(text);
                    e.target.classList.add("reading-now");
                }
            };

            const removeHoverSpeak = (e) => {
                if (!isAudioDescriptionEnabled) return;
                window.speechSynthesis.cancel();
                e.target.classList.remove("reading-now");
            };

            const textElements = document.querySelectorAll("p, h1, h2, h3, h4, h5, h6, a, li, button, label, span");
            const bindAudioEvents = () => {
                textElements.forEach(el => {
                    el.addEventListener("mouseenter", hoverSpeak);
                    el.addEventListener("mouseleave", removeHoverSpeak);
                });
                btnAudio?.classList.add("text-danger", "fw-bold");
            };

            const unbindAudioEvents = () => {
                textElements.forEach(el => {
                    el.removeEventListener("mouseenter", hoverSpeak);
                    el.removeEventListener("mouseleave", removeHoverSpeak);
                    el.classList.remove("reading-now");
                });
                btnAudio?.classList.remove("text-danger", "fw-bold");
            };

            if (isAudioDescriptionEnabled) bindAudioEvents();

            btnAudio?.addEventListener("click", () => {
                isAudioDescriptionEnabled = !isAudioDescriptionEnabled;
                localStorage.setItem("audioDescription", isAudioDescriptionEnabled);
                if (isAudioDescriptionEnabled) {
                    bindAudioEvents();
                } else {
                    unbindAudioEvents();
                }
            });

            // ACCESSIBILITY MENU TOGGLE (doesn't need to persist)
            document.getElementById('accessibilityToggle')?.addEventListener('click', function () {
                const menu = document.getElementById('accessibilityMenu');
                menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
            });
            document.getElementById('accessibilityClose')?.addEventListener('click', function () {
                document.getElementById('accessibilityMenu').style.display = 'none';
            });
        });

        </script>
    </div>
</body>
</html>
