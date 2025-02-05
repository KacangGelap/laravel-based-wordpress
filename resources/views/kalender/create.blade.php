@extends('layouts.dashboard')
@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>Tambah Agenda</h4>
                    <a href="{{route('kalender.index')}}" class="btn btn-dark">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{route('kalender.store')}}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label for="nama_kegiatan" class="col-md-4 col-form-label text-md-end">Nama Kegiatan</label>

                            <div class="col-md-6">
                                <input id="nama_kegiatan" type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required autocomplete="nama_kegiatan" autofocus>

                                @error('nama_kegiatan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="penyelenggara" class="col-md-4 col-form-label text-md-end">Penyelenggara / Yang Mengundang</label>

                            <div class="col-md-6">
                                <input id="penyelenggara" type="text" class="form-control @error('penyelenggara') is-invalid @enderror" name="penyelenggara" value="{{ old('penyelenggara') }}" required autocomplete="penyelenggara" autofocus>

                                @error('penyelenggara')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="mulai" class="col-md-4 col-form-label text-md-end">Tanggal & Jam Mulai</label>

                            <div class="col-md-6">
                                <input id="mulai" type="datetime-local" class="form-control @error('mulai') is-invalid @enderror" name="mulai" value="{{ old('mulai') }}" required autocomplete="mulai" autofocus>

                                @error('mulai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="selesai" class="col-md-4 col-form-label text-md-end">Tanggal & Jam Selesai</label>

                            <div class="col-md-6">
                                <input id="selesai" type="datetime-local" class="form-control @error('selesai') is-invalid @enderror" name="selesai" value="{{ old('selesai') }}" required autocomplete="selesai" autofocus>

                                @error('selesai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lokasi" class="col-md-4 col-form-label text-md-end">Tempat Acara</label>

                            <div class="col-md-6">
                                <input id="lokasi" type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" value="{{ old('lokasi') }}" required autocomplete="lokasi" autofocus>

                                @error('lokasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat" class="col-md-4 col-form-label text-md-end">Alamat Lengkap Tempat Acara</label>

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
                            <label for="menghadiri" class="col-md-4 col-form-label text-md-end">Yang Menghadiri</label>

                            <div class="col-md-6">
                                <input id="menghadiri" type="text" class="form-control @error('menghadiri') is-invalid @enderror" name="menghadiri" value="{{ old('menghadiri') }}" required autocomplete="menghadiri" autofocus>

                                @error('menghadiri')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
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