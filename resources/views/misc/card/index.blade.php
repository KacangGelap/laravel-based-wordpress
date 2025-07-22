@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="card min-vh-100">
            <div class="d-md-flex card-header justify-content-between">
                <div>
                    <h3>Manajemen Tampilan Kartu</h3>
                </div>
                <div>
                    <a href="{{url('/')}}" class="btn btn-dark">lihat</a>
                    <a href="{{route('card.create')}}" class="btn btn-primary {{$data->count() == 3 ? 'disabled' : ''}}">Tambah</a>
                </div>
            </div>
            <div class="card-body">
                <p class="text-secondary">Catatan: Tekan Gambar untuk mengubah data</p>
                <hr class="mb-2">
                <div class="d-flex justify-content-between">
                @forelse ($data as $d)
                <div class="card col-4">
                    <div class="card-header text-center">{{\Str::limit($d->judul, 20)}}</div>
                    <div class="card-body">
                        <a href="{{route('card.edit', $d->id)}}">
                            <img src="{{"storage/$d->image"}}" class="w-100" style="height: 300px;object-fit: cover;object-position: center;">
                        </a>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $d->id }}">
                            {{__('Hapus Gambar')}}
                        </button>
                    </div>
                </div>
                @empty
                    <div class="alert alert-info text-center">
                        Gambar tidak ditemukan.
                    </div>
                @endforelse
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
    {{-- ini kenapa outputnya true sedangkan idatas model --}}
    @foreach ($data as $item)
        <form id="hapus-{{ $item->id }}" action="{{ route('card.delete', $item->id) }}" method="POST" class="d-none">
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