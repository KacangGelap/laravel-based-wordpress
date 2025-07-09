@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{'Tambah Tautan Laman'}}</h4>
                    <a href="{{ route('embed.index') }}" class="btn btn-dark">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('embed.store')}}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row col-md-8 mx-auto mb-3">
                            <select name="kategori_id" id="" class="form-select" required>
                                <option value="">-- Pilih Kategori ---</option>
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
                        <div class="row col-md-8 mx-auto mb-3">
                            <input class="form-control @error('link') is-invalid @enderror" type="text" name="link" id="link" placeholder="Isikan link (Wajib)" value="{{old('link')}}" required >
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
@endsection
