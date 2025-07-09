@extends('layouts.dashboard')
@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>Tambah Kategori Tautan Laman</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('embed.store_category')}}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label for="kategori" class="col-md-4 col-form-label text-md-end">Kategori</label>

                            <div class="col-md-6">
                                <input class="form-control" type="text" name="kategori" id="kategori">
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