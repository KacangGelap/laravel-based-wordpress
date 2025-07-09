@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{'Ubah Gambar'}}</h4>
                    <a href="{{ route('card.index') }}" class="btn btn-dark">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('card.update',$data->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-flex col-md-8 mx-auto mb-3">
                            <input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul" id="judul" placeholder="Isikan Judul (Wajib)" value="{{old('judul') ?? $data->judul}}" required >
                            @error('judul')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-8 card shadow-sm border border-dark position-relative">
                                {{-- Preview background --}}
                                <label for="image" id="label-image" 
                                    class="d-flex flex-column justify-content-center align-items-center"
                                    style="height: 200px; cursor: pointer; background-image:url('/storage/{{$data->image}}'); background-size:cover; background-position:center; background-repeat:no-repeat;">
                                    
                                    <input type="file" id="image" name="image" class="d-none @error('image') is-invalid @enderror">
                                    
                                    {{-- Overlay tombol --}}
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <p class="btn btn-primary m-0 px-3 py-1" id="text-image">Upload gambar</p>
                                    </div>
                                </label>
                                
                                @error('image')
                                    <span class="invalid-feedback d-block text-center" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="offset-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ubah') }}
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
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar';
        document.getElementById('text-image').textContent = fileName;
        document.getElementById('label-image').style.backgroundImage = 'none';
    });
</script>
@endsection
