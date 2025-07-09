@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="card min-vh-100">
            <div class="d-md-flex card-header justify-content-between">
                <div>
                    <h3>Manajemen Galeri geser tambahan</h3>
                </div>
                <div>
                    <a href="{{url('/')}}" class="btn btn-dark">lihat</a>
                    <a href="{{route('carousel.create_category')}}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Jenis galeri geser</th>
                            <th>Total gambar</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr style="font-size: 12px">
                                <td>{{$loop->iteration}}</td>
                                <td style="text-align: justify">{{Str::limit($item->kategori,100)}}</td>
                                <td>{{$item->carousels->count()}}</td>
                                <td class="d-flex justify-content-evenly" style="font-size: 12px">
                                    <a href="{{route('carousel.carousels', $item->id)}}" class="btn btn-secondary"  data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Tooltip on bottom">
                                        <i class="bi-eye" ></i>
                                    </a>
                                    <a href="{{route('carousel.edit_category', $item->id)}}" class="btn btn-warning">
                                        <i class="bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item->id }}">
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
    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    @foreach ($data as $item)
        <form id="hapus-{{ $item->id }}" action="{{ route('carousel.delete_category', $item->id) }}" method="POST" class="d-none">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
        </form>
    @endforeach
    <script>

        const deleteModal = document.getElementById('deleteModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let Id = null;

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            Id = button.getAttribute('data-id');
        });
        confirmDeleteBtn.addEventListener('click', function () {
            if (Id) {
                document.getElementById('hapus-' + Id).submit();
            }
        });
    </script>
@endsection