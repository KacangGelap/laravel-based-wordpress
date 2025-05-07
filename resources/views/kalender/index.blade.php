@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="card">
            <div class="d-md-flex card-header justify-content-between">
                <h4>Agenda Kegiatan</h4>
                <div class="">
                    <a href="{{route('kalender.show')}}" class="btn btn-dark">Lihat Agenda</a>
                    <a href="{{route('kalender.create')}}" class="btn btn-primary">Tambah Agenda</a>
                </div>
                
            </div>
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Agenda</th>
                                <th>Penyelenggara</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Lokasi dan Alamat</th>
                                <th>Menghadiri</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr style="font-size: 12px">
                                    <td>{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                                    <td style="text-align: justify">{{$item->nama_kegiatan}}</td>
                                    <td>{{$item->penyelenggara}}</td>
                                    @php
                                        $tgl_mulai = Carbon\Carbon::parse($item->mulai)->translatedFormat('d M Y');
                                        $tgl_selesai = Carbon\Carbon::parse($item->selesai)->translatedFormat('d M Y');
                                    @endphp
                                    <td>{{$tgl_mulai === $tgl_selesai ? $tgl_mulai : "$tgl_mulai - $tgl_selesai"}}</td>
                                    <td>{{Carbon\Carbon::parse($item->mulai)->translatedFormat('H:i T')}}</td>
                                    <td>{{Carbon\Carbon::parse($item->selesai)->translatedFormat('H:i T')}}</td>
                                    <td>{{"$item->lokasi $item->alamat"}}</td>
                                    <td>{{$item->menghadiri}}</td>
                                    <td style="font-size: 12px">
                                        <div class="d-md-flex">
                                            <a href="{{route('kalender.edit', $item->id)}}" class="col btn btn-warning mx-2">
                                                <i class="bi-pencil"></i>
                                            </a>
                                            <button class="col btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item->id }}">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    @foreach ($data as $item)
        <form id="hapus-{{ $item->id }}" action="{{ route('kalender.delete', $item->id) }}" method="POST" class="d-none">
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