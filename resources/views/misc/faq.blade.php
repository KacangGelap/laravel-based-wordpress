@extends('layouts.dashboard')
@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>Tambah/Ubah page FAQ di footer</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('faq.store')}}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="">
                                <textarea class="form-control border border-dark @error('faq') is-invalid @enderror" rows="4" name="faq" required>{{\Storage::get('faq.txt')}}</textarea>
                                @error('faq')
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