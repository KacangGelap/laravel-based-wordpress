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
            <hr class="mt-4">
            @if(\Schema::hasTable('card'))
                <div class="py-4 d-flex flex-wrap justify-content-evenly gap-3">
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
            <div class="bg-primary-subtle">
                <hr>
                <h4 class="text-center my-2 fw-bold" style="font-size:40px;font-family: Dancing Script, cursive">Selayang Pandang</h4>
                <hr>
            </div>
            
            <div class="row justify-content-center py-4">
                <div class="d-flex w-100 justify-content-center">
                    <iframe 
                    loading="lazy"
                    height="500px"
                    src="https://www.youtube.com/embed/{{ \Storage::exists('profil.txt') ? \Storage::get('profil.txt') : '' }}?autoplay=0&muted=0" 
                    frameborder="0" 
                    allow="autoplay; encrypted-media" 
                    allowfullscreen
                    class="w-75">
                </iframe>
                </div>
                <a class="mt-4 text-center fw-bold btn btn-danger col-md-3 col-8">Tonton di YouTube</a>
            </div>
            <hr>
            @if(\Schema::hasTable('advanced_carousel_category') && \Schema::hasTable('advanced_carousel'))
                @foreach ($advanced_cat as $catIndex => $category)
                    @if ($category->carousels->isNotEmpty())

                    @php
                        // chunk carousels jadi per 6
                        $carouselChunks = $category->carousels->chunk(5);
                        $colors = ['#e0f0ff', '#d0ffd0', '#ffe0ff', '#fdfdcf'];
                        $timeinterval = ['2000', '0', '5000' ,'0', '7000'];
                        $bgColor = $colors[$catIndex % count($colors)];
                        $carouselId = 'carouselCat' . $category->id;
                    @endphp
                    <div class="py-3 mb-4 min-vh-50" style="">
                        {{-- Carousel khusus kategori ini --}}
                        <div id="{{ $carouselId }}" class="row carousel slide justify-content-center" data-bs-ride="carousel" data-bs-interval="{{$timeinterval[$catIndex % count($timeinterval)]}}">
                            <div class="carousel-inner w-75">
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
                            <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon rounded bg-dark py-5" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon rounded bg-dark py-5" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            {{-- Judul --}}
                            <h5 class="my-4 text-center fw-bold">{{ $category->kategori }}</h5>
                        </div>
                    </div>
                    <hr>
                    @endif
                @endforeach
            @endif
            @if(\Schema::hasTable('kalender'))
                <div class="py-4 table-responsive text-center">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Agenda</th>
                                    <th>Penyelenggara</th>
                                    <th>Tanggal</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Lokasi dan Alamat</th>
                                    <th>Menghadiri</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agenda as $agenda)
                                    <tr style="font-size: 12px">
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="text-align: justify;">{{$agenda->nama_kegiatan}}</td>
                                        <td>{{$agenda->penyelenggara}}</td>
                                        @php
                                            $tgl_mulai = Carbon\Carbon::parse($agenda->mulai)->translatedFormat('d M Y');
                                            $tgl_selesai = Carbon\Carbon::parse($agenda->selesai)->translatedFormat('d M Y');
                                        @endphp
                                        <td>{{$tgl_mulai === $tgl_selesai ? $tgl_mulai : "$tgl_mulai - $tgl_selesai"}}</td>
                                        <td>{{Carbon\Carbon::parse($agenda->mulai)->translatedFormat('H:i T')}}</td>
                                        <td>{{Carbon\Carbon::parse($agenda->selesai)->translatedFormat('H:i T')}}</td>
                                        <td style="text-align: justify;">{{"$agenda->lokasi, $agenda->alamat"}}</td>
                                        <td>{{$agenda->menghadiri}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <h5 class="fw-bold">Agenda Kegiatan</h5>
                    </div>
            @endif
            @if(\Storage::exists('quote.txt'))
                <figure class="text-center bg-secondary-subtle py-4">
                    <blockquote class="blockquote fw-bold">
                        <i>" {{ucfirst($quote)}} "</i>
                    </blockquote>
                    {{-- <figcaption class="blockquote-footer">
                        {{parse_url(url('/'), PHP_URL_HOST)}}
                    </figcaption> --}}
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
