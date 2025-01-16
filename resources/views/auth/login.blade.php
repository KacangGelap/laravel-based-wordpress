@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100">
    <div class="row justify-content-between">

        {{-- left-side --}}
        <div class="col-md-6">
            <img src="/img/auth.png" class="w-100">
        </div>
        {{-- right-side --}}
        <div class="col-md-6 my-auto">
            <div class="card min-vh-100">
                <div class="card-body">
                    <div class="d-flex py-4 justify-content-center">
                        <img src="/img/bontang.png" height="100px" class="">
                    </div>
                    <h6 class="fw-bold text-center">Selamat Datang di Website<br>{{config('app.name', 'Undefined')}}</h6>
                    <hr class="mb-5">
                    <form method="POST" action="{{ route('masuk') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pengguna') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Kata Sandi') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="g-recaptcha" class="col-md-4 col-form-label text-md-end"></label>
                            <div class="col-md-6">
                                <div name="g-recaptcha-response">
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                    @endif                                
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Ingat Saya') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Masuk') }}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
