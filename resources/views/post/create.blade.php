@extends('layouts.dashboard')
@section('content')
<form id="mainForm" action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
@csrf
<div class="bg-secondary text-end p-3 d-flex justify-content-between">
    <h4 class="text-white text-start">Tambah Postingan</h4>
    <div class="d-flex justify-content-end">
        <div class="col-auto mx-2">
        <select name="kategori_id" id="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
            <option value="{{NULL}}">Pilih Kategori</option>
            @foreach ($kategori as $item)
            <option value="{{$item->id}}">{{$item->kategori}}</option>
            @endforeach
        </select>
        @error('kategori_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>
    <button class="btn btn-success" type="submit" form="mainForm">Save Changes</button>
    </div>
    
</div>

<div class="container mt-3">
        <div class="mb-3">
            <input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul" id="judul" placeholder="Masukkan Judul" value="{{old('judul')}}">
            @error('judul')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- media 1 --}}
        <label for="media1" id="label-media1" class="d-flex flex-column justify-content-center align-items-center border border-dark rounded mb-3" style="height: 200px; cursor: pointer;">
            <input type="file" id="media1" name="media1" class="d-none @error('media1') is-invalid @enderror">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 50px; height: 50px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12" />
            </svg>
            <p class="text-center mt-2" id="text-media1">Upload gambar 1</p>
            @error('media1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </label>
        {{-- deskripsi 1 --}}
        <div class="mb-3">
            <textarea class="form-control border border-dark @error('deskripsi1') is-invalid @enderror" rows="4" placeholder="Deskripsi 1" name="deskripsi1">{{old('deskripsi1')}}</textarea>
            @error('deskripsi1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- media 2 --}}
        <label for="media2" id="label-media2" class="d-flex flex-column justify-content-center align-items-center border border-dark rounded mb-3" style="height: 200px; cursor: pointer;">
            <input type="file" id="media2" name="media2" class="d-none @error('media2') is-invalid @enderror">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 50px; height: 50px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12" />
            </svg>
            <p class="text-center mt-2" id="text-media2">Upload gambar 2</p>
            @error('media2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </label>
        {{-- deskripsi 2 --}}
        <div class="mb-3">
            <textarea class="form-control border border-dark @error('deskripsi2') is-invalid @enderror" rows="4" placeholder="Deskripsi 2" name="deskripsi2" >{{old('deskripsi2')}}</textarea>
            @error('deskripsi2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- media 3 --}}
        <label for="media3" id="label-media3" class="d-flex flex-column justify-content-center align-items-center border border-dark rounded mb-3" style="height: 200px; cursor: pointer;">
            <input type="file" id="media3" name="media3" class="d-none @error('media3') is-invalid @enderror">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 50px; height: 50px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12" />
            </svg>
            <p class="text-center mt-2" id="text-media3">Upload gambar 3</p>
            @error('media3')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </label>
        {{-- deskripsi 3 --}}
        <div class="mb-3">
            <textarea class="form-control border border-dark @error('deskripsi3') is-invalid @enderror" rows="4" placeholder="Deskripsi 3" name="deskripsi3" >{{old('deskripsi3')}}</textarea>
            @error('deskripsi3')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</form>

<script>
    document.getElementById('media1').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar 1';
        document.getElementById('text-media1').textContent = fileName;
    });

    document.getElementById('media2').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar 2';
        document.getElementById('text-media2').textContent = fileName;
    });

    document.getElementById('media3').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar 3';
        document.getElementById('text-media3').textContent = fileName;
    });
</script>

@endsection
