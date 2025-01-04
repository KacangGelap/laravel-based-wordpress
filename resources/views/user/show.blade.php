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
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{$user->name}}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels" for="no_hp">HP / WA</label>
                            <input id="no_hp" type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="" value="{{$user->no_hp}}">
                            @error('no_hp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels" for="opd">Perangkat Daerah</label>
                            <select id="opd" name="opd" class="form-select @error('opd') is-invalid @enderror">
                                <option selected disabled value="{{NULL}}">[{{$user->opd}}]</option>
                                @if(Auth::user()->role == 'admin')
                                    <option value="Diskominfo">Diskominfo</option>
                                    <option value="Korpri">Korpri</option>
                                    <option value="Pkk">Pkk</option>
                                    <option value="Setda">Setda</option>
                                    <option value="Setwan">Setwan</option>
                                    <option value="Itda">Itda</option>
                                    <option value="Disdikbud">Disdikbud</option>
                                    <option value="Dinkes">Dinkes</option>
                                    <option value="Dpupr">Dpupr</option>
                                    <option value="Dpkpp">Dpkpp</option>
                                    <option value="Dpkp">Dpkp</option>
                                    <option value="Dspm">Dspm</option>
                                    <option value="Dpmptsp">Dpmptsp</option>
                                    <option value="Disnaker">Disnaker</option>
                                    <option value="Dlh">Dlh</option>
                                    <option value="Disdukcapil">Disdukcapil</option>
                                    <option value="Dishub">Dishub</option>
                                    <option value="Disporapar">Disporapar</option>
                                    <option value="Dkukmp">Dkukmp</option>
                                    <option value="Dpk">Dpk</option>
                                    <option value="Dkppp">Dkppp</option>
                                    <option value="Dppkb">Dppkb</option>
                                    <option value="Satpol PP">Satpol PP</option>
                                    <option value="Bkpsdm">Bkpsdm</option>
                                    <option value="Bapperinda">Bapperinda</option>
                                    <option value="Bapenda">Bapenda</option>
                                    <option value="Bpkad">Bpkad</option>
                                    <option value="Bakesbangpol">Bakesbangpol</option>
                                    <option value="Bpbd">Bpbd</option>
                                    <option value="Rsud">Rsud</option>
                                    <option value="Ukpbj">Ukpbj</option>
                                    <option value="Puskesmas Bontang Selatan 1">Puskesmas Bontang Selatan 1</option>
                                    <option value="Puskesmas Bontang Selatan 2">Puskesmas Bontang Selatan 2</option>
                                    <option value="Puskesmas Bontang Utara 1">Puskesmas Bontang Utara 1</option>
                                    <option value="Puskesmas Bontang Utara 2">Puskesmas Bontang Utara 2</option>
                                    <option value="Puskesmas Bontang Barat">Puskesmas Bontang Barat</option>
                                    <option value="Puskesmas Bontang Lestari">Puskesmas Bontang Lestari</option>
                                    <option value="Laboratorium Kesehatan">Laboratorium Kesehatan</option>
                                    <option value="Kec-Bontang Barat">Kec-Bontang Barat</option>
                                    <option value="Kec-Bontang Utara">Kec-Bontang Utara</option>
                                    <option value="Kec-Bontang Selatan">Kec-Bontang Selatan</option>
                                    <option value="Kel-Kanaan">Kel-Kanaan</option>
                                    <option value="Kel-Belimbing">Kel-Belimbing</option>
                                    <option value="Kel-Gunung Telihan">Kel-Gunung Telihan</option>
                                    <option value="Kel-Bontang Baru">Kel-Bontang Baru</option>
                                    <option value="Kel-Api-Api">Kel-Api-Api</option>
                                    <option value="Kel-Gunung Elai">Kel-Gunung Elai</option>
                                    <option value="Kel-Guntung">Kel-Guntung</option>
                                    <option value="Kel-Loktuan">Kel-Loktuan</option>
                                    <option value="Kel-Tanjung Laut">Kel-Tanjung Laut</option>
                                    <option value="Kel-Tanjung Laut Indah">Kel-Tanjung Laut Indah</option>
                                    <option value="Kel-Berbas Tengah">Kel-Berbas Tengah</option>
                                    <option value="Kel-Berbas Pantai">Kel-Berbas Pantai</option>
                                    <option value="Kel-Satimpo">Kel-Satimpo</option>
                                    <option value="Kel-Bontang Lestari">Kel-Bontang Lestari</option>
                                @endif
                            </select>
                            @error('opd')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels" for="username">Username</label>
                            <input id="username" type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="enter your e-mail address" value="{{$user->username}}" required>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <h6 class="mt-4">Perbarui kata sandi</h6>
                        <hr>                        
                        <div class="col-md-12">
                            <label class="labels" for="password">Kata Sandi</label>
                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Isi jika kata sandi ingin diganti">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels" for="password-confirm">Ulangi Kata Sandi</label>
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="Isi jika kata sandi ingin diganti">
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