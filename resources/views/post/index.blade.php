@extends('layouts.dashboard')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                <div class="card">
                    <div class="d-flex card-header justify-content-between">
                        <h3>Manajemen Berita</h3>
                        <div>
                            <a href="{{route('post.create')}}" class="btn btn-primary">Tambah</a>
                            <a href="{{url()->previous()}}" class="btn btn-dark">&larr; Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <h5>Jumlah Kategori Berita :</h5>
                            <p class="mb-1">Kegiatan = {{$kegiatan}}</p>
                            <p class="mb-1">Informasi = {{$informasi}}</p>
                            <p class="mb-1">Apel Pagi = {{$apelPagi}}</p>
                            <p class="mb-1">Kerja Bakti = {{$kerjaBakti}}</p>
                        </div>
                        <div class="table-responsive text-center">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Diunggah tanggal</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr style="font-size: 12px">
                                            <td>{{$loop->iteration}}</td>
                                            <td style="text-align: justify">{{Str::limit($item->judul,100)}}</td>
                                            <td>{{$item->kategori->kategori}}</td>
                                            <td>{{Carbon\Carbon::parse($item->updated_at)->translatedFormat('d M Y H:i T')}}</td>
                                            <td class="d-flex justify-content-evenly" style="font-size: 12px">
                                                <a href="{{route('post.view',['post' => $item->id])}}" class="btn btn-secondary"  data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Tooltip on bottom">
                                                    <i class="bi-eye" ></i>
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