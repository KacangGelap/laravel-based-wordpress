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
</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white h-100 min-vh-100">
                        <p class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline">Dashboard</span>
                        </p>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li>
                                <a href="{{route('user.index')}}" class="nav-link px-0 align-middle text-white">
                                    <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Pengguna</span> </a>
                            </li>
                            <li>
                                <a href=" {{ route('template.index') }} " class="nav-link align-middle px-0 text-white">
                                    <i class="fs-4 bi-pencil-square"></i> <span class="ms-1 d-none d-sm-inline">Banner</span>
                                </a>
                            </li>
                            <li>
                                <a href=" {{ route('menu.index') }} " class="nav-link align-middle px-0 text-white">
                                    <i class="fs-4 bi-file-earmark-code"></i> <span class="ms-1 d-none d-sm-inline">Navigasi</span>
                                </a>
                            </li>
                            <li>
                                <a href=" {{ route('template.index') }} " class="nav-link align-middle px-0 text-white">
                                    <i class="fs-4 bi-pencil-square"></i> <span class="ms-1 d-none d-sm-inline">Galeri Geser</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href=" {{ route('post.index') }} " class="nav-link align-middle px-0 text-white">
                                    <i class="fs-4 bi-camera"></i> <span class="ms-1 d-none d-sm-inline">Berita</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href=" {{ route('home') }} " class="nav-link align-middle px-0 text-white">
                                    <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Informasi Website</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href=" {{ url('/') }} " class="nav-link align-middle px-0 text-white w-100">
                                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Masuk Website</span>
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <div class="dropdown pb-4">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-person-circle"></i>
                                <span class="d-none d-sm-inline mx-1">{{Str::limit(Auth::user()->name, 15)}}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                @if(Auth::user()->role == 'admin')<li><a class="dropdown-item" href="#">Aktifitas Situs</a></li>@endif
                                <li><a class="dropdown-item" href="{{route('user.profile',Auth::Id())}}">Profil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign out</a>
                                </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col py-3">
                    @yield('content')
                </div>
                @if (session('sukses'))
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
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
                </script>
            </div>
        </div>
    </div>
</body>
</html>
