@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{'Tambah Gambar di Samping Kanan Layar'}}</h4>
                    <a href="{{ route('jadwal-pelayanan.index') }}" class="btn btn-dark">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('jadwal-pelayanan.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex col-md-8 mx-auto mb-3">
                            <input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul" id="judul" placeholder="Judul Gambar" value="{{$text ?? old('judul')}}" required >
                            @error('judul')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="image" id="label-image" class="mx-auto col-md-8 d-flex flex-column justify-content-center align-items-center border border-dark rounded mb-3" 
                            @php
                            if($layanan){
                                $version = \Storage::lastModified($layanan);
                            }
                            else{
                                $version = time();
                            }
                            @endphp

                            style="height: 200px; cursor: pointer; background-image:url('/storage/{{ $layanan }}?v={{ $version }}'); background-size:cover; background-position:center; background-repeat:no-repeat;">
                                <input type="file" id="image" name="image" class="d-none @error('image') is-invalid @enderror">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 50px; height: 50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12" />
                                </svg>
                                <p class="text-center mt-2 bg-primary-subtle btn" id="text-image">Upload gambar</p>
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
                                    {{ __('Simpan') }}
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
    document.getElementById('label-image').style.backgroundImage = 'none';
});
</script>
@endsection
