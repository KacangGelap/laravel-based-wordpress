@extends('layouts.main')
@section('content')
<div class="container-fluid shadow-sm min-vh-100">
    <div class="row py-4">
        <div class="col-lg-8">
            <div id="galeriGeser" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($carousel as $data)
                    <div class="carousel-item {{$loop->first ? 'active' : ''}} rounded" data-bs-interval="10000">
                        
                            <img src="{{asset('storage/'.$data->media)}}" class="d-block w-100 rounded" alt="..." style="height:500px; object-fit: contain; object-repeat: no-repeat;" data-bs-toggle="modal" data-bs-target="#mediaModal" data-bs-image="{{asset('storage/'.$data->media)}}">
                            @if (isset($data->text))
                                <div class="carousel-caption position-absolute bottom-0 start-0 end-0">
                                    <h5 style="background:rgba(0, 0, 0, 0.6);color:yellow" class="fst-italic mx-5 py-2">{{$data->text}}</h4>
                                </div>
                            @endif
                        
                    </div>
                    @endforeach
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#galeriGeser" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon rounded py-5" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#galeriGeser" data-bs-slide="next">
                        <span class="carousel-control-next-icon rounded py-5" aria-hidden="true"></span>
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
                                <h5 class="m-0 fst-italic">{{ $c->judul }}</h5>
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
            @if(\Storage::exists('profil.txt') &&\Storage::exists('profil.mp4'))
               <div class="row justify-content-center">
                <div class="position-relative w-100" style="max-width: 720px;">
                    <video 
                        src="{{ asset('storage/profil.mp4') }}" 
                        class="w-100"
                        style="height: auto; max-height: 400px;"
                        autoplay
                        controls
                        loop
                        loading="lazy">
                    </video>

                    <a href="https://www.youtube.com/embed/{{ \Storage::get('profil.txt') }}"
                    class="text-white fw-thin text-decoration-none position-absolute px-3 py-2"
                    style="bottom: 10px; left: 12px; z-index: 10; background-color:rgba(0, 0, 0, 0.6)"
                    target="_blank">
                        Tonton di <span class="text-danger bi-youtube" style="font-family: impact"> <span class="text-white">YouTube</span></span>
                    </a>
                </div>
            </div>


            @endif
            <hr>
            @if(\Schema::hasTable('advanced_carousel_category') && \Schema::hasTable('advanced_carousel'))
                @foreach ($advanced_cat as $catIndex => $category)
                    @if ($category->carousels->isNotEmpty())

                    @php
                        $carouselChunks = ($catIndex != 0 && $catIndex != 4) ? $category->carousels->chunk(4) : $category->carousels->chunk(8);
                        $colors = ['#e0f0ff', '#d0ffd0', '#ffe0ff', '#fdfdcf'];
                        $timeinterval = [0, 2000, 5000 ,8000, 0];
                        $bgColor = $colors[$catIndex % count($colors)];
                        $carouselId = 'carouselCat' . $category->id;
                    @endphp
                    <div class="py-3 mb-4 min-vh-50" style="" loading="lazy">
                        <div id="{{ $carouselId }}" class="row carousel carousel-dark slide justify-content-center" 
                        @if($catIndex != 0 && $catIndex != 4)
                            data-bs-ride="carousel"
                            data-bs-interval="{{ $timeinterval[$catIndex % count($timeinterval)] }}"
                        @endif
                        >
                            <div class="carousel-inner w-75">
                                @foreach ($carouselChunks as $chunkIndex => $chunk)
                                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                        <div class="row justify-content-center g-3">
                                            @foreach ($chunk as $carousel)
                                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 position-relative img-hover-container" data-bs-toggle="modal"
                                                        data-bs-target="#mediaModal"
                                                        data-bs-image="{{ asset('storage/' . $carousel->media) }}">
                                                    <img src="{{ asset('storage/' . $carousel->media) }}"
                                                        class="img-fluid shadow"
                                                        style="object-fit:{{($catIndex != 0 && $catIndex != 4) ? 'cover':'fill'}};height:120px; cursor:pointer"
                                                        alt="image" 
                                                        loading="lazy"/>
                                                        <div class="img-hover-overlay">
                                                            <h5 class="fst-italic">{{ $carousel->judul }}</h5>
                                                        </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                           @if($category->carousels->count() > 4)
                                <!-- Tombol carousel -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon rounded py-5" aria-hidden="true" style="color:rgba(0, 0, 0, 0.3)"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon rounded py-5" aria-hidden="true" style="color:rgba(0, 0, 0, 0.3)"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif

                        </div>
                        {{-- Judul --}}
                            <h5 class="mt-4 text-center fw-bold">{{ $category->kategori }}</h5>
                    </div>
                    <hr>
                    @endif
                @endforeach
            @endif
            @if(\Schema::hasTable('kalender'))
                <div class="py-4 table-responsive text-center" loading="lazy">
                        <table class="table table-striped table-bordered table-hover">
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
                        <h5 class="fw-bold">Agenda Kegiatan Terkini</h5>
                    </div>
            @endif
            @if(\Storage::exists('quote.txt'))
                <figure class="text-center" style="background-color: #e7f1ff;
color: #1a1a1a;">
                    <blockquote class="blockquote fw-bold py-4">
                        <i>"{{$quote}}"</i>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
