@extends('layouts.dashboard')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                <div class="card">
                    <div class="d-flex card-header justify-content-between">
                        <h3>Link Terkait</h3>
                        <div>
                            <a href="{{route('link.create')}}" class="btn btn-primary">Tambah Link</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-center">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Url</th>
                                        <th>Url</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr style="font-size: 12px">
                                            <td>{{$loop->iteration}}</td>
                                            <td style="text-align: justify">{{$item->nama}}</td>
                                            <td style="text-align: justify">{{$item->url}}</td>
                                            <td class="" style="font-size: 12px">
                                                <div class="d-md-flex">
                                                    <a href="{{$item->url}}" target="_blank" rel="noopener noreferrer" class="col btn btn-secondary"><i class="bi bi-eye"></i></a>
                                                    <a href="{{route('link.edit', ['link'=>$item->id])}}" class="col btn btn-warning mx-2">
                                                        <i class="bi-pencil"></i>
                                                    </a>
                                                    <button class="col btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item->id }}">
                                                        <i class="bi-trash"></i>
                                                    </button>    
                                                </div>
                                            </td>
                                        </tr>
                                        <form id="hapus-{{ $item->id }}" action="{{ route('link.delete', $item->id) }}" method="POST" class="d-none">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
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
                    Apakah Anda yakin ingin menghapus data ini?                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>
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