@extends('layouts.dashboard')
@section('content')
<form method="POST" @if(Route::current()->getName() == 'user.profile') action="{{ route('user.update.profile',$user->id) }}"  @else action="{{ route('user.update',$user->id) }}" @endif enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    @csrf
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="text-end">
                <a href="{{Route::current()->getName() == 'user.show' ? route('user.index') : route('home')}}" class="btn btn-dark">&larr; Kembali</a>
            </div>
            <div class="col-md-4 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle my-5" @if($user->profile == null)width="150px"@endif src="{{$user->profile ?? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'}}">
                    <input class="form-control @error('profile') is-invalid @enderror" type="file" name="profile">
                    @error('profile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <p class="text-info">keterangan: format gambar berdimensi 1:1 dengan extensi .jpg, .png</p>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels" for="name">Nama Lengkap</label>
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="enter your name" value="{{$user->name}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels" for="no_hp">HP / WA</label>
                            <input id="no_hp" type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="enter your no_hp" value="{{$user->no_hp}}">
                            @error('no_hp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels" for="opd">Perangkat Daerah</label>
                            <input id="opd" type="text" name="opd" class="form-control @error('opd') is-invalid @enderror" placeholder="" value="{{$user->opd}}">
                            @error('opd')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels" for="email">Email</label>
                            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="enter your e-mail address" value="{{$user->email}}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels" for="password">Kata Sandi</label>
                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Keterangan : Hanya untuk mengganti password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels" for="password-confirm">Ulangi Kata Sandi</label>
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="Keterangan : Hanya untuk mengganti password">
                        </div>
                        
                        <div class="my-4 offset-md-8">
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</form>
@endsection