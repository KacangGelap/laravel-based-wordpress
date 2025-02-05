@extends('layouts.main')
@section('content')
<div class="container-fluid bg-light shadow-sm min-vh-100">
    <div class="row py-4">
        <div class="col-lg-8">
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($carousel as $data)
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
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div> 
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
