@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tambah Pengguna') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lengkap') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
                                <p class="text-danger mb-0">Isi nama pengguna dengan hati-hati karena akan digunakan untuk masuk ke aplikasi.</p>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="opd" class="col-md-4 col-form-label text-md-end">{{ __('Perangkat Daerah') }}</label>

                            <div class="col-md-6">
                                <select id="opd" name="opd" class="form-select @error('opd') is-invalid @enderror" required>
                                    <option selected disabled>Pilih Perangkat Daerah</option>
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
                                </select>
                                @error('opd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_hp" class="col-md-4 col-form-label text-md-end">{{ __('HP / WA') }}</label>

                            <div class="col-md-6">
                                <input id="no_hp" type="number" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" autocomplete="no_hp">

                                @error('no_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Kata Sandi') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <p class="text-danger mb-0">Password harus meliputi huruf besar, huruf kecil, angka serta simbol dengan minimal 8 karakter</p>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Ulangi Kata Sandi') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Tambah Pengguna') }}
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
