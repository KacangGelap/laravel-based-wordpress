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
                            <a href="{{route('post.view', ['post'=>$data->id])}}" class="pb-2 col-md-3 rounded text-decoration-none" >
                                <img src="{{asset('storage/'.$data->media1)}}" class="w-100 rounded img-fluid" style="height:250px;object-fit:cover" loading="lazy">
                            </a>
                            @if($data->media2)<a href="{{route('post.view', ['post'=>$data->id])}}" class="pb-2 col-md-3 rounded text-decoration-none">
                                <img src="{{asset('storage/'.$data->media2)}}" class="w-100 rounded img-fluid" style="height:250px;object-fit:cover" loading="lazy">
                            </a>@endif
                            @if($data->media3)<a href="{{route('post.view', ['post'=>$data->id])}}" class="pb-2 col-md-3 rounded text-decoration-none">
                                <img src="{{asset('storage/'.$data->media3)}}" class="w-100 rounded img-fluid" style="height:250px;object-fit:cover" loading="lazy">
                            </a>@endif
                            @if($data->media4)<a href="{{route('post.view', ['post'=>$data->id])}}" class="pb-2 col-md-3 rounded text-decoration-none">
                                <img src="{{asset('storage/'.$data->media4)}}" class="w-100 rounded img-fluid" style="height:250px;object-fit:cover" loading="lazy">
                            </a>@endif
                        @endforeach
                    @endif
                    @if($submenu->count() >= 1)
                        @foreach ($submenu as $data)
                            @if(Str::startsWith(\Illuminate\Support\Facades\File::mimeType(public_path('storage/'. $data->media)), 'images/'))<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="col-md-3 rounded text-decoration-none">
                                <img src="{{asset('storage/'.$data->media)}}" class="w-100 rounded img-fluid" style="height:250px; object-fit:cover" loading="lazy">
                            </a>@endif
                            @if($data->tambahan1)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="pb-2 col-md-3 rounded text-decoration-none">
                                <img src="{{asset('storage/'.$data->tambahan1)}}" class="w-100 rounded img-fluid" style="height:250px; object-fit:cover" loading="lazy">
                            </a>@endif
                            @if($data->tambahan2)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="pb-2 col-md-3 rounded text-decoration-none">
                                <img src="{{asset('storage/'.$data->tambahan2)}}" class="w-100 rounded img-fluid" style="height:250px; object-fit:cover" loading="lazy">
                            </a>@endif
                            @if($data->tambahan3)<a href="{{route('page.show', ['id'=>$data->halaman->first()->id])}}" class="pb-2 col-md-3 rounded text-decoration-none">
                                <img src="{{asset('storage/'.$data->tambahan3)}}" class="w-100 rounded img-fluid" style="height:250px; object-fit:cover" loading="lazy">
                            </a>@endif
                        @endforeach
                    @endif
                    <h4 class="my-4">Galeri Video</h4>
                    <hr>
                    @foreach($video as $item)
                        <iframe src="https://youtube.com/embed/{{$item}}" height="400px"></iframe>
                    @endforeach
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
