@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="row mx-2 my-4">
            <div class="col-lg-8">
                <h4 class="mb-4">Galeri Foto</h4>
                <hr>
                <div class="row">
                    @if($berita->count() >= 1)
                        @foreach ($berita as $data)
                            <a href="{{route('post.view', ['post'=>$data->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->media1)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>
                            @if($data->media2)<a href="{{route('post.view', ['post'=>$data->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->media2)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->media3)<a href="{{route('post.view', ['post'=>$data->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->media3)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->media4)<a href="{{route('post.view', ['post'=>$data->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->media4)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                        @endforeach
                    @endif
                    @if($submenu->count() >= 1)
                        @foreach ($submenu as $data)
                            @if(\Storage::mimeType('public/'. $data->media) != 'application/pdf')<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->media)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->tambahan1)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->tambahan1)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->tambahan2)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->tambahan2)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->tambahan3)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->tambahan3)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                        @endforeach
                    @endif
                    @if($subsubmenu->count() >= 1)
                        @foreach ($subsubmenu as $data)
                            @if(\Storage::mimeType('public/'. $data->media) != 'application/pdf')<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->media)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->tambahan1)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->tambahan1)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->tambahan2)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->tambahan2)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->tambahan3)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->tambahan3)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                        @endforeach
                    @endif
                    @if($subsubsubmenu->count() >= 1)
                        @foreach ($subsubsubmenu as $data)
                            @if(\Storage::mimeType('public/'. $data->media) != 'application/pdf')<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->media)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->tambahan1)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->tambahan1)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->tambahan2)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->tambahan2)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                            @if($data->tambahan3)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none" style="background-image: url({{asset('storage/'.$data->tambahan3)}}); background-size:cover; background-position:50% 50%;height:250px">&nbsp;</a>@endif
                        @endforeach
                    @endif
                    <h4 class="my-4">Galeri Video</h4>
                    <hr>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
@endsection