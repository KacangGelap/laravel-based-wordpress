@extends('layouts.main')
@section('content')
    <div class="container-fluid min-vh-100">
        <div class="row py-4">
            <div class="col-lg-8">
                @if($berita->count() >= 1)
                    <h4 class="mx-4 mb-4">{{\Route::current()->getName() === 'post.list' ? 'List Berita' : 'Hasil Pencarian : '.$query}}</h4>
                    <hr>
                    @foreach ($berita as $item)
                        <a href="{{route('post.view',['post'=> $item->id])}}" class="text-decoration-none text-dark">
                            <div class="d-md-flex justify-content-between">
                                <span class="w-100 rounded mx-4" style="background-image: url({{asset('storage/'.$item->media1)}}); background-size:cover; background-position:50% 50%;height:300px">&nbsp;</span>
                                <span>
                                    <h5 class="d-md-flex align-items-center">{{$item->judul}} <span class="ms-4 text-danger" style="font-size: 12px">{{$item->kategori->kategori}}</span></h5>
                                    <p>
                                        {{Str::limit($item->deskripsi,'100'). ' Baca Selengkapnya'}}
                                    </p>
                                </span>
                            </div>
                        </a>
                        <hr>
                    @endforeach
                @else
                <h4 class="text-muted text-center">Tidak Ada Berita</h4>
                @endif
            </div>
    
            @include('layouts.sidebar')
        </div>  
    </div>
@endsection