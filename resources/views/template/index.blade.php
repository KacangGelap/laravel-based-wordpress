@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="card">
            <div class="d-md-flex card-header justify-content-between">
                @php
                    $routeName = \Route::current()->getName();
                @endphp
                <h4>{{$routeName === 'banner.index' ? 'Banner Website' : 'Galeri Geser Website'}}</h4>
                <a href="{{$routeName === 'banner.index' ? route('banner.create') : route('slider.create')}}" class="btn btn-primary @if($routeName === 'banner.index' && isset($data->media)) disabled @elseif($routeName === 'banner.index') @elseif ($data->count() === 5) disabled @endif">Tambah {{$routeName === 'banner.index' ? 'Banner' : 'Galeri Geser'}}</a>
            </div>
            <div class="card-body">
                @if($routeName === 'banner.index')
                    @if(isset($data->media))
                    <a href="{{route('banner.edit', $data->id)}}">
                        <img src="{{asset('storage/'.$data->media)}}" class="w-100">
                    </a>
                    @else
                    <h3 class="text-muted text-center">Tidak Ada Banner</h3>
                    @endif
                @else
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($data as $data)
                            <div class="carousel-item {{$loop->first ? 'active' : ''}} rounded" data-bs-interval="5000">
                                <a href="{{route('slider.edit', ['slider'=> $data->id])}}">
                                    <img src="{{asset('storage/'.$data->media)}}" class="d-block w-100 rounded" alt="..." style="height: 350px; object-fit: cover;">
                                    @if (isset($data->text))
                                        <div class="rounded carousel-caption position-absolute bottom-0 start-0 end-0" style="background-color: rgba(0, 0, 0, 0.7)">
                                            <p>{{$data->text}}</p>
                                        </div>
                                    @endif
                                </a>
                            </div>
                            @endforeach
                            
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                        </button>
                    </div> 
                @endif
            </div>
        </div>
    </div>
@endsection