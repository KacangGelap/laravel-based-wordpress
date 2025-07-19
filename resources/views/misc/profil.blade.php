@extends('layouts.dashboard')
@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>Tambah/Ubah profil di halaman depan</h4>
                </div>
                <div class="card-body">
                    
                    <form action="{{route('video.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(\Storage::exists('profil.mp4'))
                            <video src="{{ asset("storage/$video") }}" autoplay muted loop controls class="w-100" height="400px"></video>
                        @else
                            <div class="d-flex w-100 bg-secondary-subtle align-items-center" style="height: 400px">
                                <h5 class="mx-auto text-center">Video tidak ditemukan / belum diupload  </h5>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <label for="video" class="col-md-4 col-form-label text-md-end">Upload Video</label>

                            <div class="col-md-6">
                                <input class="form-control" type="file" name="video" id="video">
                                @error('video')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <iframe src="{{"https://youtube.com/embed/$profil"}}" frameborder="0" class="w-100" height="400px"></iframe>
                        <div class="row mb-3">
                            <label for="profil" class="col-md-4 col-form-label text-md-end">Link Youtube</label>

                            <div class="col-md-6">
                                <input class="form-control" type="text" name="profil" id="profil" value="{{"https://youtube.com/embed/$profil"}}">
                                @error('profil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0 justify-content-end">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Simpan')}}
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