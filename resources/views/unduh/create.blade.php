@extends('layouts.dashboard')
@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>Tambah File</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('unduh.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="media" class="col-md-4 col-form-label text-md-end">Masukkan File</label>

                            <div class="col-md-6">
                                <input id="media" type="file" class="form-control @error('media') is-invalid @enderror" name="media" value="{{ old('media') }}" required autocomplete="media" autofocus>

                                @error('media')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kategori" class="col-md-4 col-form-label text-md-end">Masukkan Kategori File</label>

                            <div class="col-md-6">
                                <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror">
                                    <option selected disabled>[Pilih Kategori File]</option>
                                    @foreach ($filecat as $item)
                                        <option value="{{$item->id}}">{{$item->cat}}</option>
                                    @endforeach  
                                </select>

                                @error('kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Tambah')}}
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