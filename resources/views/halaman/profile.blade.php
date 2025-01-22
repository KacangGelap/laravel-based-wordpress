@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{ __('Isi Identitas PD/UPT') }}</h4>
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
                            <label for="alamat" class="col-md-4 col-form-label text-md-end">Alamat Lengkap</label>

                            <div class="col-md-6">
                                <input id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" required autocomplete="alamat" autofocus>

                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="telp" class="col-md-4 col-form-label text-md-end">Nomor Telepon</label>

                            <div class="col-md-6">
                                <input id="telp" type="number" class="form-control @error('telp') is-invalid @enderror" name="telp" value="{{ old('telp') }}" required autocomplete="telp" autofocus>

                                @error('telp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Alamat Surel</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="website" class="col-md-4 col-form-label text-md-end">URL Website</label>

                            <div class="col-md-6">
                                <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website') }}" required autocomplete="website" autofocus placeholder="https://nama-website.bontangkota.go.id">

                                @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <h4>Sosial Media (opsional)</h4>
                        <div class="row mb-3">
                            <label for="instagram" class="col-md-4 col-form-label text-md-end">Link Profile Instagram</label>

                            <div class="col-md-6">
                                <input id="instagram" type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram" value="{{ old('instagram') }}" autocomplete="instagram" autofocus>

                                @error('instagram')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="facebook" class="col-md-4 col-form-label text-md-end">Link Profile Facebook PD / UPT</label>

                            <div class="col-md-6">
                                <input id="facebook" type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook" value="{{ old('facebook') }}" autocomplete="facebook" autofocus>

                                @error('facebook')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="youtube" class="col-md-4 col-form-label text-md-end">Link Channel YouTube PD / UPT</label>

                            <div class="col-md-6">
                                <input id="youtube" type="text" class="form-control @error('youtube') is-invalid @enderror" name="youtube" value="{{ old('youtube') }}" autocomplete="youtube" autofocus>

                                @error('youtube')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tiktok" class="col-md-4 col-form-label text-md-end">Link Profile TikTok PD / UPT</label>

                            <div class="col-md-6">
                                <input id="tiktok" type="text" class="form-control @error('tiktok') is-invalid @enderror" name="tiktok" value="{{ old('tiktok') }}" autocomplete="tiktok" autofocus>

                                @error('tiktok')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="x" class="col-md-4 col-form-label text-md-end">Link Profile X (Twitter) PD / UPT</label>

                            <div class="col-md-6">
                                <input id="x" type="text" class="form-control @error('x') is-invalid @enderror" name="x" value="{{ old('x') }}" autocomplete="x" autofocus>

                                @error('x')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <h4>Frame Google Maps (opsional)</h4>
                        <div class="row mb-3">
                            <label for="maps" class="col-md-4 col-form-label text-md-end">Google Map Embed</label>

                            <div class="col-md-6">
                                <input id="maps" type="text" class="form-control @error('maps') is-invalid @enderror" name="maps" value="{{ old('maps') }}" autocomplete="maps" autofocus>

                                @error('maps')
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
