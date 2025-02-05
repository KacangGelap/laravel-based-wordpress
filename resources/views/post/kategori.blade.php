@extends('layouts.dashboard')
@section('content')
    @php
        $routeName = \Route::current()->getName();
        if ($routeName === 'post.category.create') {
            $title = 'Tambah Kategori';
            $routeUrl = route('post.category.store');
        }elseif($routeName === 'post.category.edit'){
            $title = 'Edit Kategori';
            $routeUrl = route('post.category.update', $data->id);
        }
    @endphp
    <div class="container col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>{{$title}}</h4>
            </div>
            <div class="card-body">
                <form action="{{$routeUrl}}" method="post">
                    @csrf
                    @if($routeName === 'post.category.edit')
                        @method('PUT')
                    @endif
                    <div class="row mb-3">
                        <label for="kategori" class="col-md-4 col-form-label text-md-end">{{ __('Nama Kategori') }}</label>

                        <div class="col-md-6">
                            <input id="kategori" type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" value="{{ $routeName === 'post.category.edit' ? $data->kategori : old('kategori') }}" required autocomplete="kategori">

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
                                {{ __('Tambah') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection