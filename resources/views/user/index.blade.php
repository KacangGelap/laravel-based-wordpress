@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                <div class="card">
                    <div class="d-flex card-header justify-content-between">
                        <h3>Manajemen Pengguna</h3>
                        <a href="{{ url()->previous() }}" class="btn btn-dark">&larr;back</a>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah Pengguna</a>
                        <div class="table-responsive text-center">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Lengkap & Jabatan</th>
                                        <th>E-Mail</th>
                                        <th>No. HP / WA</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->no_hp }}</td>
                                            <td class="d-flex justify-content-start">
                                                <a href="{{ route('user.show', $item->id) }}" class="btn btn-secondary mx-2">
                                                    <i class="bi-eye"></i>
                                                </a>
                                                <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning mx-2">
                                                    <i class="bi-pencil"></i>
                                                </a>
                                                @if ($item->id != Auth::user()->id)
                                                    <button class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-user-id="{{ $item->id }}">
                                                        <i class="bi-trash"></i>
                                                    </button>
                                                @endif
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
                    Apakah Anda yakin ingin menghapus pengguna ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    @foreach ($user as $item)
        <form id="hapus-pengguna-{{ $item->id }}" action="{{ route('user.delete', $item->id) }}" method="POST" class="d-none">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
        </form>
    @endforeach
    <script>

        const deleteModal = document.getElementById('deleteModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let userId = null;

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            userId = button.getAttribute('data-user-id');
        });
        confirmDeleteBtn.addEventListener('click', function () {
            if (userId) {
                document.getElementById('hapus-pengguna-' + userId).submit();
            }
        });
    </script>
@endsection