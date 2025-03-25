@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{'Edit Gambar'}}</h4>
                    @php
                        $routeName = \Route::current()->getName();
                    @endphp
                    <a href="{{ $routeName === 'banner.edit' ? route('banner.index') : route('slider.index') }}" class="btn btn-dark">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{$routeName === 'banner.edit' ? route('banner.update', $data->id) : route('slider.update', $data->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if($routeName === 'slider.edit')
                        <div class="row mb-3">
                            <label for="text" class="col-md-4 col-form-label text-md-end">Subtitle Gambar (opsional)</label>

                            <div class="col-md-6">
                                <input id="text" type="text" class="form-control @error('text') is-invalid @enderror" name="text" value="{{ $data->text ?? old('text') }}" autocomplete="text" autofocus>

                                @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end">Urutan Galeri Geser</label>

                            <div class="col-md-6">
                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                                    <option selected disabled>[Pilih Urutan Galeri Geser]</option>
                                    <option value="carousel-1" {{ $data_exist->where('type','carousel-1')->isNotEmpty() ? 'disabled' : '' }}>Slider-1</option>
                                    <option value="carousel-2" {{ $data_exist->where('type','carousel-2')->isNotEmpty() ? 'disabled' : '' }}>Slider-2</option>
                                    <option value="carousel-3" {{ $data_exist->where('type','carousel-3')->isNotEmpty() ? 'disabled' : '' }}>Slider-3</option>
                                    <option value="carousel-4" {{ $data_exist->where('type','carousel-4')->isNotEmpty() ? 'disabled' : '' }}>Slider-4</option>
                                    <option value="carousel-5" {{ $data_exist->where('type','carousel-5')->isNotEmpty() ? 'disabled' : '' }}>Slider-5</option>
                                </select>                                
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        @endif
                        <div class="row mb-3">
                            <label for="media" id="label-media" class="mx-auto col-md-8 d-flex flex-column justify-content-center align-items-center border border-dark rounded mb-3" style="height: 200px; cursor: pointer; background-image:url({{asset('storage/'.$data->media)}}); background-size:cover; background-position:0% 50%">
                                <input type="file" id="media" name="media" class="d-none @error('media') is-invalid @enderror">
                                
                                <p class="text-center mt-2 btn btn-primary" id="text-media">Upload gambar</p>
                                @error('media')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
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
    document.getElementById('media').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar';
        document.getElementById('text-media').textContent = fileName;
        document.getElementById('label-media').style.backgroundImage = 'none';
    });

</script>
@endsection
