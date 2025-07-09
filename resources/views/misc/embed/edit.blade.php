@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{'Ubah Tautan Laman'}}</h4>
                    <a href="{{ route('embed.embeds', $data->category->id) }}" class="btn btn-dark">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('embed.update',$data->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-flex col-md-8 mx-auto mb-3">
                            <select name="kategori_id" id="" class="form-select" required>
                                <option value="{{$data->category->id}}">-- {{$data->category->kategori}} --</option>
                                @foreach ($cat as $cat)
                                    <option value="{{$cat->id}}">{{$cat->kategori}}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex col-md-8 mx-auto mb-3">
                            <input class="form-control @error('link') is-invalid @enderror" type="text" name="link" id="link" placeholder="Isikan link (Wajib)" value="{{old('link') ?? $data->link}}" required >
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
@endsection
