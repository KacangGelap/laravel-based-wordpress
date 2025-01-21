@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="card min-vh-100">
            <div class="d-md-flex card-header justify-content-between">
                <div>
                    <h3>List Sub-Sub-Sub-Menu Pada Sub-Sub-Menu {{$subsubmenu->sub_sub_menu}}</h3>
                    <div class="container fw-bold text-secondary">
                        <a href="{{ route('menu.index') }}" class="text-dark text-decoration-none">Menu</a>
                        <span class="mx-1">></span>
                        <span class="text-capitalize">{{ strtolower($subsubmenu->submenu->menu->menu) }}</span>
                        <span class="mx-1">></span>
                        <a href="{{ route('submenu.index', $subsubmenu->submenu->menu->id) }}" class="text-dark text-decoration-none">Sub-Menu</a>
                        <span class="mx-1">></span>
                        <span class="text-capitalize">{{ strtolower($subsubmenu->submenu->sub_menu) }}</span>
                        <span class="mx-1">></span>
                        <a href="{{ route('subsubmenu.index', $subsubmenu->submenu->id) }}" class="text-dark text-decoration-none">Sub-Sub-Menu</a>
                        <span class="mx-1">></span>
                        <span class="text-capitalize">{{ strtolower($subsubmenu->sub_sub_menu) }}</span>
                        <span class="mx-1">></span>
                        <a href="{{ route('subsubsubmenu.index', $subsubmenu->id) }}" class="text-dark text-decoration-none">Sub-Sub-Sub-Menu</a>
                    </div>
                </div>
                <div><a href="{{route('menu.index')}}" class="btn btn-dark">Kembali</a></div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th class="text-start">Sub-Sub-Menu</th>
                                <th>Tipe</th>
                                <th>Keterangan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subsubsubmenu as $item)
                                <tr>
                                    <td style="font-size: 12px">{{$loop->iteration}}</td>
                                    <td class="text-sm-start" style="font-size: 12px">{{ $item->sub_sub_sub_menu }}</td>
                                    <td style="font-size: 12px"> {{$item->type}}</td>
                                    <td style="font-size: 12px"></td>
                                    <td class="" style="font-size: 12px">
                                        @if($item->type == 'page')
                                        <a href="#" class="btn btn-secondary mx-2">
                                            <i class="bi bi-box-arrow-up-right"></i> Lihat Tampilan Sub-Sub-Sub-menu
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