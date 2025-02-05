@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="card min-vh-100">
            <div class="d-md-flex card-header justify-content-between">
                <div>
                    <h3>Navigasi</h3>
                    <div class="container fw-bold text-secondary">
                        <a href="{{ route('menu.index') }}" class="text-dark text-decoration-none">Menu</a>
                    </div>
                </div>
                <div>
                    <form action="{{route('menu.store')}}" method="post">
                        @csrf
                        <div class="input-group">
                                <input class="form-control" type="text" name="menu" required placeholder="Isikan Menu Baru">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <hr class="mb-2">
                <div class="table-responsive text-center">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Menu</th>
                                <th>Keterangan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menu as $item)
                                <tr>
                                    <td style="font-size: 12px">{{$loop->iteration}}</td>
                                    <td class="text-sm-start" style="font-size: 12px">{{ $item->menu }}</td>
                                    <td style="font-size: 12px">Jumlah Sub-Menu : {{ $item->subMenus->count() }}</td>
                                    <td class="" style="font-size: 12px">
                                        <a href="{{ route('submenu.index', ['menu' => $item->id]) }}" class="btn btn-secondary mx-2" style="font-size: 12px">
                                            <i class="bi-eye"></i> Lihat Daftar Sub-Menu
                                        </a>
                                        <button class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item->id }}">
                                            <i class="bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                Catatan: Menu <b>Galeri, Unduh, dan Agenda Kegiatan</b> dibuat secara otomatis oleh aplikasi
                <hr>
                {{-- <h3>Daftar File yang Bisa Diunduh (di Menu Unduh)</h3>
                <div class="table-responsive text-center">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama File</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menu as $item)
                                <tr>
                                    <td style="font-size: 12px">{{$loop->iteration}}</td>
                                    <td class="text-sm-start" style="font-size: 12px">{{ $item->menu }}</td>
                                    <td class="" style="font-size: 12px">
                                        <a href="{{ route('submenu.index', ['menu' => $item->id]) }}" class="btn btn-secondary mx-2" style="font-size: 12px">
                                            <i class="bi-download"></i> Unduh File
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}
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
    @foreach ($menu as $item)
        <form id="hapus-{{ $item->id }}" action="{{ route('menu.delete', $item->id) }}" method="POST" class="d-none">
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