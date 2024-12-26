@extends('layouts.dashboard')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                <div class="card">
                    <div class="d-flex card-header justify-content-between">
                        manajemen postingan
                        <a href="{{url()->previous()}}" class="btn btn-dark">&larr;back</a>
                    </div>
                    <div class="card-body">
                        <a href="{{route('post.create')}}" class="btn btn-primary">Tambah Postingan</a>
                        <div class="table-responsive text-center">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Diupdate tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{Str::limit($item->judul,50)}}</td>
                                            <td>{{$item->kategori->kategori}}</td>
                                            <td>{{Carbon\Carbon::parse($item->updated_at)->translatedFormat('d M Y H:i T')}}</td>
                                            <td class="d-flex justify-content-evenly">
                                                <a href="{{route('post.view',['post' => $item->id])}}" class="btn btn-secondary">
                                                    <i class="bi-eye"></i>
                                                </a>
                                                <a href="{{route('post.edit',['post'=> $item->id])}}" class="btn btn-warning">
                                                    <i class="bi-pencil"></i>
                                                </a>
                                                <a onclick="event.preventDefault();document.getElementById('hapus-postingan-{{$item->id}}').submit();" class="btn btn-danger">
                                                    <i class="bi-trash"></i>
                                                </a>
                                                <form id="hapus-postingan-{{$item->id}}" action="" method="POST" class="d-none">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection