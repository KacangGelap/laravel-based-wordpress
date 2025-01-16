@extends('layouts.dashboard')
@section('content')
    <div class="container">

        <div class="card min-vh-100">
            <div class="d-flex card-header justify-content-between">
                <h3>List Sub-Menu Pada Menu {{$menu->menu}}</h3>
                <a href="{{route('menu.index')}}" class="btn btn-dark">Kembali</a>
            </div>
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th class="text-start">Sub-Menu</th>
                                <th>Tipe</th>
                                <th>Keterangan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($submenu as $item)
                                <tr>
                                    <td style="font-size: 12px">{{$loop->iteration}}</td>
                                    <td class="text-sm-start" style="font-size: 12px">{{ $item->sub_menu }}</td>
                                    <td style="font-size: 12px"> {{$item->type}}</td>
                                    <td style="font-size: 12px"></td>
                                    <td class="" style="font-size: 12px">
                                        @if($item->type == 'dropdown')
                                        <a href="{{ route('submenu.index', ['menu' => $item->id]) }}" class="btn btn-secondary mx-2">
                                            <i class="bi-eye"></i> Lihat List Sub-Sub-Menu
                                        </a>
                                        @elseif($item->type == 'page')
                                        <a href="#" class="btn btn-secondary mx-2">
                                            <i class="bi bi-box-arrow-up-right"></i> Lihat Tampilan Submenu
                                        </a>
                                        @elseif($item->type == 'link')
                                        <a href="#" target="_blank" rel="noopener noreferrer" class="btn btn-secondary mx-2">
                                            <i class="bi bi-box-up-right"></i> Tujui Link
                                        </a>
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
@endsection