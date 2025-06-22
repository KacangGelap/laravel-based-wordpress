@extends('layouts.main')
@section('content')
    <div class="container-fluid min-vh-100">
        <div class="row py-4">
            <div class="col-lg-8">
                @if($berita->count() >= 1)
                    <h4 class="mx-4 mb-4">{{\Route::current()->getName() === 'post.list' ? 'List Berita' : 'Hasil Pencarian : '.$query}}</h4>
                    <div class="d-flex justify-content-center">{{$berita->links()}}</div>
                    <hr>
                    @foreach ($berita as $item)
                        <a href="{{route('post.view',['post'=> $item->id])}}" class="text-decoration-none text-dark">
                            <div class="row justify-content-between">
                                <span class="col">
                                    <img class="w-100 rounded px-4" height="300px" style="object-fit:cover" src="{{asset('storage/'.$item->media1)}}">    
                                </span>
                                
                                <span class="col">
                                    <h5 class="d-md-flex align-items-center">{{$item->judul}} <span class="ms-4 text-danger" style="font-size: 12px">{{$item->kategori->kategori}}</span></h5>
                                    <p>
                                        {{Str::limit($item->deskripsi,'100'). ' Baca Selengkapnya'}}
                                    </p>
                                </span>
                            </div>
                        </a>
                        <hr>
                    @endforeach
                    <div class="d-flex justify-content-center">{{$berita->links()}}</div>
                @else
                <h4 class="text-muted text-center">Tidak Ada Berita</h4>
                @endif
            </div>
    
            @include('layouts.sidebar')
        </div>  
    </div>
@endsection
