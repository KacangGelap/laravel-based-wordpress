@extends('layouts.dashboard')
@section('content')
<form id="mainForm" action="{{route('post.update',['post'=>$post->id])}}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    @csrf
    <div class="bg-secondary text-end p-3 d-flex justify-content-between">
        <h4 class="text-white text-start">Edit Berita</h4>
        <div class="d-flex justify-content-end">
            <div class="col-auto mx-2">
            <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                <option value="{{$post->kategori_id}}">[{{$post->kategori->kategori}}]</option>
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
        {{-- judul --}}
        <div class="input-group mb-3">
            <span class="input-group-text">Judul Berita :</span>
            <input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul" id="judul" placeholder="Masukkan Judul" value="{{old('judul') ?? $post->judul}}">
            @error('judul')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- contributor --}}
        <div class="input-group mb-3">
            <span class="input-group-text">Kontributor :</span>
            <input class="form-control @error('contributor') is-invalid @enderror" type="text" name="contributor" id="contributor" placeholder="Isikan nama kontributor berita (wajib [contoh : Devan Apriandi]), nama kontributor boleh sama dengan nama editor" value="{{$post->contributor}}">
            @error('contributor')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- deskripsi --}}
        <div class="mb-3">
            <textarea class="form-control border border-dark @error('deskripsi') is-invalid @enderror" rows="4" placeholder="Deskripsi 2" name="deskripsi">{{old('deskripsi') ?? $post->deskripsi}}</textarea>
            @error('deskripsi')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row justify-content-center">
           <div class="col-md-3">
                <div class="card shadow-sm border border-dark position-relative">
                    {{-- Preview background --}}
                    <label for="media1" id="label-media1" 
                        class="d-flex flex-column justify-content-center align-items-center"
                        style="height: 200px; cursor: pointer; background-image:url('/storage/{{$post->media1}}'); background-size:cover; background-position:center; background-repeat:no-repeat;">
                        
                        <input type="file" id="media1" name="media1" class="d-none @error('media1') is-invalid @enderror">
                        
                        {{-- Overlay tombol --}}
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <p class="btn btn-primary m-0 px-3 py-1" id="text-media1">Upload gambar 1</p>
                        </div>
                    </label>
                    {{-- Checkbox Hapus --}}
                    <div class="d-flex form-check justify-content-center bg-light py-2">
                        <input class="form-check-input me-2" type="checkbox" name="" id="" disabled>
                        <label class="form-check-label large" for="">
                            Hapus gambar
                        </label>
                    </div>
                    @error('media1')
                        <span class="invalid-feedback d-block text-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border border-dark position-relative">
                    {{-- Preview background --}}
                    <label for="media2" id="label-media2" 
                        class="d-flex flex-column justify-content-center align-items-center"
                        style="height: 200px; cursor: pointer; background-image:url('/storage/{{$post->media2}}'); background-size:cover; background-position:center; background-repeat:no-repeat;">
                        
                        <input type="file" id="media2" name="media2" class="d-none @error('media2') is-invalid @enderror">
                        
                        {{-- Overlay tombol --}}
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <p class="btn btn-primary m-0 px-3 py-1" id="text-media2">Upload gambar 2</p>
                        </div>
                    </label>
                   {{-- Checkbox Hapus --}}
                    <div class="d-flex form-check justify-content-center bg-light py-2">
                        <input class="form-check-input me-2" 
                            type="checkbox" 
                            name="hapus_media2" 
                            id="hapus_media2" 
                            value="1"
                            {{ empty($post->media2) ? 'disabled' : '' }}>
                            
                        <label class="form-check-label large" for="hapus_media2">
                            Hapus gambar
                        </label>
                    </div>
                    @error('media2')
                        <span class="invalid-feedback d-block text-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border border-dark position-relative">
                    {{-- Preview background --}}
                    <label for="media3" id="label-media3" 
                        class="d-flex flex-column justify-content-center align-items-center"
                        style="height: 200px; cursor: pointer; background-image:url('/storage/{{$post->media3}}'); background-size:cover; background-position:center; background-repeat:no-repeat;">
                        
                        <input type="file" id="media3" name="media3" class="d-none @error('media3') is-invalid @enderror">
                        
                        {{-- Overlay tombol --}}
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <p class="btn btn-primary m-0 px-3 py-1" id="text-media3">Upload gambar 3</p>
                        </div>
                    </label>
                   {{-- Checkbox Hapus --}}
                    <div class="d-flex form-check justify-content-center bg-light py-2">
                        <input class="form-check-input me-2" 
                            type="checkbox" 
                            name="hapus_media3" 
                            id="hapus_media3" 
                            value="1"
                            {{ empty($post->media3) ? 'disabled' : '' }}>
                            
                        <label class="form-check-label large" for="hapus_media3">
                            Hapus gambar
                        </label>
                    </div>
                    @error('media3')
                        <span class="invalid-feedback d-block text-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border border-dark position-relative">
                    {{-- Preview background --}}
                    <label for="media4" id="label-media4" 
                        class="d-flex flex-column justify-content-center align-items-center"
                        style="height: 200px; cursor: pointer; background-image:url('/storage/{{$post->media4}}'); background-size:cover; background-position:center; background-repeat:no-repeat;">
                        
                        <input type="file" id="media4" name="media4" class="d-none @error('media4') is-invalid @enderror">
                        
                        {{-- Overlay tombol --}}
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <p class="btn btn-primary m-0 px-3 py-1" id="text-media4">Upload gambar 3</p>
                        </div>
                    </label>
                   {{-- Checkbox Hapus --}}
                    <div class="d-flex form-check justify-content-center bg-light py-2">
                        <input class="form-check-input me-2" 
                            type="checkbox" 
                            name="hapus_media4" 
                            id="hapus_media4" 
                            value="1"
                            {{ empty($post->media4) ? 'disabled' : '' }}>
                            
                        <label class="form-check-label large" for="hapus_media4">
                            Hapus gambar
                        </label>
                    </div>
                    @error('media4')
                        <span class="invalid-feedback d-block text-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('media1').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar 1';
        document.getElementById('text-media1').textContent = fileName;
        document.getElementById('label-media1').style.backgroundImage = 'none';
    });

    document.getElementById('media2').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar 2';
        document.getElementById('text-media2').textContent = fileName;
        document.getElementById('label-media2').style.backgroundImage = 'none';
    });

    document.getElementById('media3').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar 3';
        document.getElementById('text-media3').textContent = fileName;
        document.getElementById('label-media3').style.backgroundImage = 'none';
    });
    document.getElementById('media4').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar 3';
        document.getElementById('text-media4').textContent = fileName;
        document.getElementById('label-media4').style.backgroundImage = 'none';
    });
</script>


@endsection
