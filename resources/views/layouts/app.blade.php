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
        <main class="py-4 bg-light">  
            @yield('content')
        </main>         
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
    </div>
</body>
</html>
