@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{ __('Tambah Video Youtube') }}</h4>
                    <a href="{{route('submenu.index', session('menu_id'))}}" class="btn btn-dark">Kembali</a>
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
                            <label for="yt_id" class="col-md-4 col-form-label text-md-end">Link Video Youtube</label>

                            <div class="col-md-6">
                                <input id="yt_id" type="text" class="form-control @error('yt_id') is-invalid @enderror" name="yt_id" value="{{ old('yt_id') }}" required autocomplete="yt_id" autofocus>

                                @error('yt_id')
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
