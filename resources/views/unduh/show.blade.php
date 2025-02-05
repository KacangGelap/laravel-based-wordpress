@extends('layouts.main')
@section('content')
    <div class="row justify-content-center py-4">
        <div class="col-md-10">
            <div class="container">
                <div class="card">
                    <div class="d-flex card-header justify-content-between">
                        <h3>Unduh</h3>
                    </div>
                    <div class="card-body">
                        <hr>
                        @foreach ($filecat as $item)
                            <h4 class="text-decoration-underline">{{$item->cat}}</h4>
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
                                        @foreach ($item->unduh as $file)
                                            <tr style="font-size: 12px">
                                                <td>{{$loop->iteration}}</td>
                                                <td style="text-align: justify">{{$file->nama}}</td>
                                                <td class="" style="font-size: 12px">
                                                    <div class="d-md-flex">
                                                        <a href="{{asset("storage/$file->media")}}" target="_blank" rel="noopener noreferrer" class="col btn btn-secondary"><i class="bi bi-eye"></i></a>
                                                        <a href="{{route('unduh-file', $file->id)}}" class="col btn btn-dark mx-2">
                                                            <i class="bi-download"></i>
                                                        </a>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                            <form id="hapus-{{ $file->id }}" action="{{ route('unduh.delete', $file->id) }}" method="POST" class="d-none">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                            </form>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
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
                    Apakah Anda yakin ingin menghapus file ini?                    
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