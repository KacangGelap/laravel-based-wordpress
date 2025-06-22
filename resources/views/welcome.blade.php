@extends('layouts.main')
@section('content')
<div class="container-fluid bg-light shadow-sm min-vh-100">
    <div class="row py-4">
        <div class="col-lg-8">
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($carousel as $data)
                    <div class="carousel-item {{$loop->first ? 'active' : ''}} rounded" data-bs-interval="3000">
                        
                            <img src="{{asset('storage/'.$data->media)}}" class="d-block w-100 rounded" alt="..." style="height:500px; object-fit: contain; object-repeat: no-repeat;" data-bs-toggle="modal" data-bs-target="#mediaModal" data-bs-image="{{asset('storage/'.$data->media)}}">
                            @if (isset($data->text))
                                <div class="rounded carousel-caption position-absolute bottom-0 start-0 end-0" style="background-color: rgba(0, 0, 0, 0.3)">
                                    <h4 style="font-family:fantasy;color:yellow">{{$data->text}}</h4>
                                </div>
                            @endif
                        
                    </div>
                    @endforeach
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div> 
            </div>
            <h5 class="fw-bold mt-4">Government Public Relation</h5>
            <hr class="mb-2">
            {{-- GPR --}}
            <script type="text/javascript" src="js/gpr.min.js" async></script>
            <div class="rounded py-5" style="background-color:#23277B;border: 6px solid #23277B!important">
                <div id="gpr-kominfo-widget-body"></div>
            </div>  
        </div>

        @include('layouts.sidebar')
    </div>
     
</div>
<div class="modal fade" id="mediaModal" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
