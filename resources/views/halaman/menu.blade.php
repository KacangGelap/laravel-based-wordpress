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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                Catatan: Menu Galeri Tidak ditambahkan karena dibuat secara otomatis oleh aplikasi
                <hr>
                <h3>Daftar File yang Bisa Diunduh (di Menu Unduh)</h3>
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
                </div>
            </div>
        </div>
    </div>
@endsection