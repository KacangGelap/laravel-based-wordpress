@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{'Tambah Gambar'}}</h4>
                    @php
                        $routeName = \Route::current()->getName();
                    @endphp
                    <a href="{{ $routeName === 'banner.create' ? route('banner.index') : route('slider.index') }}" class="btn btn-dark">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{$routeName === 'banner.create' ? route('banner.store') : route('slider.store')}}" enctype="multipart/form-data">
                        @csrf
                        @if($routeName === 'slider.create')
                        <div class="row mb-3">
                            <label for="text" class="col-md-4 col-form-label text-md-end">Subtitle Gambar (opsional)</label>

                            <div class="col-md-6">
                                <input id="text" type="text" class="form-control @error('text') is-invalid @enderror" name="text" value="{{ old('text') }}" autocomplete="text" autofocus>

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
                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option selected disabled>[Pilih Urutan Galeri Geser]</option>
                                    <option value="carousel-1" {{$data->where('type','carousel-1')->isNotEmpty() ? 'disabled' : ''}}>Slider-1</option>
                                    <option value="carousel-2" {{$data->where('type','carousel-2')->isNotEmpty() ? 'disabled' : ''}}>Slider-2</option>
                                    <option value="carousel-3" {{$data->where('type','carousel-3')->isNotEmpty() ? 'disabled' : ''}}>Slider-3</option>
                                    <option value="carousel-4" {{$data->where('type','carousel-4')->isNotEmpty() ? 'disabled' : ''}}>Slider-4</option>
                                    <option value="carousel-5" {{$data->where('type','carousel-5')->isNotEmpty() ? 'disabled' : ''}}>Slider-5</option>
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
                            <label for="media" id="label-media" class="mx-auto col-md-8 d-flex flex-column justify-content-center align-items-center border border-dark rounded mb-3" style="height: 200px; cursor: pointer;">
                                <input type="file" id="media" name="media" class="d-none @error('media') is-invalid @enderror">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 50px; height: 50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12" />
                                </svg>
                                <p class="text-center mt-2" id="text-media">Upload gambar</p>
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
    document.getElementById('media').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih gambar 1';
        document.getElementById('text-media').textContent = fileName;
    });
</script>
@endsection
