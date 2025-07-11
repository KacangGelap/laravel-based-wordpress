@extends('layouts.dashboard')
@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>Tambah/Ubah quote di halaman depan</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('quote.store')}}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="">
                                <textarea class="form-control border border-dark @error('quote') is-invalid @enderror" rows="4" name="quote" required>{{\Storage::get('quote.txt')}}</textarea>
                                @error('quote')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex mb-0 justify-content-end">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Simpan')}}
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