@extends('layouts.main')
@section('content')
<div class="container-fluid bg-light shadow-sm min-vh-100">
    <div class="row py-4">
        <div class="col-lg-8">
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active rounded" data-bs-interval="5000">
                        <img src="/img/background-app.jpeg" class="d-block w-100 rounded" alt="..." style="height: 350px; object-fit: cover;">
                        <div class="rounded carousel-caption position-absolute bottom-0 start-0 end-0" style="background-color: rgba(0, 0, 0, 0.7)">
                            <h5>Tes Carousel</h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item rounded" data-bs-interval="5000">
                        <img src="/img/112.jpeg" class="d-block w-100 rounded" alt="..." style="height: 350px; object-fit: cover;">
                    </div>
                    <div class="carousel-item bg-dark rounded" data-bs-interval="5000">
                        <a href="{{ route('post.view', ['post' => $latest->first()->id]) }}">
                            <img src="{{$latest->first()->media1}}" class="d-block w-100 img-fluid rounded mx-auto" alt="..." style="height: 350px; object-fit: cover;">
                            <div class="rounded carousel-caption position-absolute bottom-0 start-0 end-0" style="background-color: rgba(0, 0, 0, 0.7)">
                                <h5>{{__('Berita Terbaru')}}</h5>
                                <p>{{$latest->first()->judul}}</p>
                            </div>
                        </a>
                    </div>
                    </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div> 
            
            <h5 class="fw-bold mt-4">Government Public Relation</h5>
            <hr class="mb-2">
            {{-- GPR --}}
            <script type="text/javascript" src="https://widget.kominfo.go.id/gpr-widget-kominfo.min.js" async></script>
            <div class="rounded py-5" style="background-color:#23277B;border: 6px solid #23277B!important">
                <div id="gpr-kominfo-widget-body"></div>
            </div>  
        </div>

        @include('layouts.sidebar')
    </div>
     
</div>
@endsection
