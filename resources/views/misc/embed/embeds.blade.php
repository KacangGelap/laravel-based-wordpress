@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="card min-vh-100">
            <div class="d-md-flex card-header justify-content-between">
                <div>
                    <h3>{{"Daftar Gambar pada $cat->kategori"}}</h3>
                </div>
                <div>
                    <a href="{{url('/')}}" class="btn btn-dark">lihat</a>
                    <a href="{{route('embed.create')}}" class="btn btn-primary">Tambah</a>
                    <a href="{{route('embed.index')}}" class="btn btn-danger">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul Halaman</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                {{-- {{dd($item->currentpage);}} --}}
                                <td>{{Str::limit(ucfirst($item->currentpage->sub_sub_sub_sub_menu ?? $item->currentpage->sub_sub_sub_menu ?? $item->currentpage->sub_sub_menu ?? $item->currentpage->sub_menu),100)}}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{e($item->link)}}" class="btn btn-secondary mx-2">
                                        Pratinjau
                                    </a>
                                    <a href="{{route('embed.edit', $item->id)}}" class="btn btn-warning">
                                        Edit
                                    </a>
                                    <button class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item->id }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">{{$data->links()}}</div>
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
    {{-- ini kenapa outputnya true sedangkan idatas model --}}
    @foreach ($data as $item)
        <form id="hapus-{{ $item->id }}" action="{{ route('embed.delete', $item->id) }}" method="POST" class="d-none">
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