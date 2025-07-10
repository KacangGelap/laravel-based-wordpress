@extends('layouts.main')
@section('content')
<style>
    .img-hover-container {
        position: relative;
        overflow: hidden;
    }

    .img-hover-container img {
        display: block;
        width: 100%;
        height: 300px;
        object-fit: cover;
        object-position: center;
    }

    .img-hover-overlay {
        position: absolute;
        bottom: -100%; /* sembunyi di bawah */
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6); /* overlay hitam transparan */
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 10px;
        transition: all 0.4s ease-in-out;
    }

    .img-hover-container:hover .img-hover-overlay {
        bottom: 0; /* geser ke atas saat hover */
    }
</style>
<div class="container-fluid bg-light shadow-sm min-vh-100">
    <div class="row py-4">
        <div class="col-lg-8">
            <div id="galeriGeser" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($carousel as $data)
                    <div class="carousel-item {{$loop->first ? 'active' : ''}} rounded" data-bs-interval="10000">
                        
                            <img src="{{asset('storage/'.$data->media)}}" class="d-block w-100 rounded" alt="..." style="height:500px; object-fit: contain; object-repeat: no-repeat;" data-bs-toggle="modal" data-bs-target="#mediaModal" data-bs-image="{{asset('storage/'.$data->media)}}">
                            @if (isset($data->text))
                                <div class="carousel-caption position-absolute bottom-0 start-0 end-0">
                                    <h5 style="background:rgba(0, 0, 0, 0.6);color:yellow" class="mx-5 py-2">{{$data->text}}</h4>
                                </div>
                            @endif
                        
                    </div>
                    @endforeach
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#galeriGeser" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon rounded bg-dark py-5" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#galeriGeser" data-bs-slide="next">
                        <span class="carousel-control-next-icon rounded bg-dark py-5" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div> 
            </div>
            @if(\Schema::hasTable('card'))
                <div class="mt-4 py-2 d-flex flex-wrap justify-content-evenly gap-3">
                    @foreach ($card as $c)
                        <div class="col-md-3 img-hover-container" data-bs-toggle="modal" data-bs-target="#mediaModal" data-bs-image="{{ asset('storage/'.$c->image) }}">
                            <img src="{{ asset('storage/'.$c->image) }}" alt="Image">
                            <div class="img-hover-overlay">
                                <h5 class="m-0">{{ $c->judul }}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <hr>
            <h4 class="text-center my-2">Selayang Pandang</h4>
            <hr>
            <iframe 
                loading="lazy"
                height="500px"
                src="https://www.youtube.com/embed/{{ \Storage::exists('profil.txt') ? \Storage::get('profil.txt') : '' }}?autoplay=1&muted=0" 
                frameborder="0" 
                allow="autoplay; encrypted-media" 
                allowfullscreen
                class="p-2 w-100 py-4">
            </iframe>
            @if(\Schema::hasTable('advanced_carousel_category') && \Schema::hasTable('advanced_carousel'))
                @foreach ($advanced_cat as $catIndex => $category)
                    @if ($category->carousels->isNotEmpty())

                    @php
                        // chunk carousels jadi per 6
                        $carouselChunks = $category->carousels->chunk(6);
                        $colors = ['#e0f0ff', '#d0ffd0', '#ffe0ff', '#fdfdcf'];
                        $bgColor = $colors[$catIndex % count($colors)];
                        $carouselId = 'carouselCat' . $category->id;
                    @endphp
                    <div class="p-3 mb-4" style="background-color: {{ $bgColor }}">
                        {{-- Carousel khusus kategori ini --}}
                        <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                            <div class="carousel-inner">
                                @foreach ($carouselChunks as $chunkIndex => $chunk)
                                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                        <div class="row justify-content-center g-3">
                                            @foreach ($chunk as $carousel)
                                                <div class="col-6 col-sm-6 col-md-4 col-lg-2 position-relative">
                                                    <img src="{{ asset('storage/' . $carousel->media) }}"
                                                        class="img-fluid rounded shadow"
                                                        style="height: 150px; object-fit: cover; cursor:pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#mediaModal"
                                                        data-bs-image="{{ asset('storage/' . $carousel->media) }}"
                                                        alt="image" 
                                                        loading="lazy"/>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                            {{-- Judul --}}
                            <h5 class="mt-4 text-center fw-bold">{{ $category->kategori }}</h5>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
            @if(\Storage::exists('quote.txt'))
                <figure class="text-center bg-secondary-subtle py-4">
                    <blockquote class="blockquote">
                        <p>{{ucfirst($quote)}}</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        {{parse_url(url('/'), PHP_URL_HOST)}}
                    </figcaption>
                </figure>
            @endif
        </div>
        @include('layouts.sidebar')
    </div>
</div>
<div class="modal fade" id="mediaModal" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="w-100 img-fluid" alt="Media">
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
         const modal = document.getElementById('mediaModal');
         const modalImage = document.getElementById('modalImage');

         modal.addEventListener('show.bs.modal', function (event) {
             const button = event.relatedTarget;
             const imageUrl = button.getAttribute('data-bs-image');
             modalImage.src = imageUrl;
         });
     });
 </script>
@endsection
