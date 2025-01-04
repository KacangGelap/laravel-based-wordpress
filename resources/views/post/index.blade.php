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
                                                <a href="{{route('post.view',['post' => $item->id])}}" class="btn btn-secondary mx-2"  data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Tooltip on bottom">
                                                    <i class="bi-eye" ></i>
                                                </a>
                                                <a href="{{route('post.edit',['post'=> $item->id])}}" class="btn btn-warning mx-2">
                                                    <i class="bi-pencil"></i>
                                                </a>
                                                <button class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-berita-id="{{ $item->id }}">
                                                    <i class="bi-trash"></i>
                                                </button>
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
    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus berita ini?                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    @foreach ($data as $item)
        <form id="hapus-berita-{{ $item->id }}" action="{{ route('post.delete', $item->id) }}" method="POST" class="d-none">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
        </form>
    @endforeach
    <script>

        const deleteModal = document.getElementById('deleteModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let beritaId = null;

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            beritaId = button.getAttribute('data-berita-id');
        });
        confirmDeleteBtn.addEventListener('click', function () {
            if (beritaId) {
                document.getElementById('hapus-berita-' + beritaId).submit();
            }
        });
    </script>
@endsection