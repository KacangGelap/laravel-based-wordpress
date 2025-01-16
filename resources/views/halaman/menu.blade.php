@extends('layouts.dashboard')
@section('content')
    <div class="container">

        <div class="card min-vh-100">
            <div class="card-header">
                <h3>Halaman</h3>
            </div>
            <div class="card-body">
                <form action="{{route('menu.store')}}" method="post">
                    @csrf
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="menu" required placeholder="Tambah Menu">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
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
                                        <a href="{{ route('submenu.index', ['menu' => $item->id]) }}" class="btn btn-secondary mx-2">
                                            <i class="bi-eye"></i> Lihat List Sub-Menu
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