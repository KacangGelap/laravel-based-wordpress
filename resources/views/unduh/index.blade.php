@extends('layouts.dashboard')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                <div class="card">
                    <div class="d-flex card-header justify-content-between">
                        <h3>Unduh</h3>
                        <div>
                            <a href="{{route('unduh.create')}}" class="btn btn-primary">Tambah</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="d-md-flex justify-content-between">
                                <h5>Jumlah Kategori pada Menu Unduh :</h5>
                                <div class="">
                                    <a href="{{route('unduh.category.create')}}" class="btn btn-primary"> Tambah Kategori Unduh </a>
                                </div>
                            </div>
                            @foreach ($filecat as $item)
                                <p class="mb-1"><a href="{{route('unduh.category.edit', $item->id)}}" class="btn btn-warning" style="font-size: 10px"><i class="bi-pencil"></i></a> <a class="btn btn-danger" onclick="event.preventDefault();document.getElementById('delete-category-{{$item->id}}').submit();" style="font-size: 10px"><i class="bi-trash"></i></a> {{$item->cat}} = {{$item->unduh->count()}}</p>
                                <form id="delete-category-{{$item->id}}" action="{{ route('unduh.category.delete', $item->id) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
                            @endforeach
                        </div>
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
                                                        <a href="{{route('unduh.edit',$file->id)}}" class="col btn btn-warning mx-2">
                                                            <i class="bi-pencil"></i>
                                                        </a>
                                                        <button class="col btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $file->id }}">
                                                            <i class="bi-trash"></i>
                                                        </button>    
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