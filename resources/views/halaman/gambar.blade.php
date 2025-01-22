@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{ __('Tambah Gambar') }}</h4>
                    <a href="{{Route::current()->getName() === 'submenu.create' ? route('submenu.index', session('menu_id')) : (Route::current()->getName() === 'subsubmenu.create' ? route('subsubmenu.index', session('sub_menu_id')) : route('subsubsubmenu.index', session('sub_sub_menu_id')))}}" class="btn btn-dark">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ Route::current()->getName() == 'submenu.create' ? route('submenu.store', session('menu_id')) : (Route::current()->getName() == 'subsubmenu.create' ? route('subsubmenu.store', session('sub_menu_id')) : route('subsubsubmenu.store', 'sub_sub_menu_id')) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="judul" class="col-md-4 col-form-label text-md-end">Judul {{Route::current()->getName() == 'submenu.create' ? 'Sub-Menu' : (Route::current()->getName() == 'subsubmenu.create' ? 'Sub-Sub-Menu' : 'Sub-Sub-Sub-Menu')}}</label>

                            <div class="col-md-6">
                                <input id="judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" required autocomplete="judul" autofocus>

                                @error('judul')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">Masukkan Gambar</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" required autocomplete="image" autofocus>

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Tambah') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
