@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{'Tambah Gambar Galeri Geser'}}</h4>
                    <a href="{{ route('carousel.index') }}" class="btn btn-dark">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('carousel.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex col-md-8 mx-auto mb-3">
                            <input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul" id="judul" placeholder="Isikan Judul (Wajib)" value="{{old('judul')}}" required >
                            @error('judul')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex col-md-8 mx-auto mb-3">
                            <select name="kategori_id" id="" class="form-select" required>
                                <option value="">-- Pilih Jenis Galeri Geser ---</option>
                                @foreach ($cat as $data)
                                    <option value="{{$data->id}}">{{$data->kategori}}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="image" id="label-image" class="mx-auto col-md-8 d-flex flex-column justify-content-center align-items-center border border-dark rounded mb-3" style="height: 200px; cursor: pointer;">
                                <input type="file" id="image" name="image" class="d-none @error('image') is-invalid @enderror">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 50px; height: 50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12" />
                                </svg>
                                <p class="text-center mt-2" id="text-image">Upload gambar</p>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
                        </div>
                        <div class="row mb-0">
                            <div class="offset-md-8">
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
<script>
    document.getElementById('image').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar 1';
        document.getElementById('text-image').textContent = fileName;
    });
</script>
@endsection
