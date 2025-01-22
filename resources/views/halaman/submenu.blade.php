@extends('layouts.dashboard')
@section('content')
    <div class="container">   
        <div class="card min-vh-100">
            <div class="d-flex card-header justify-content-between">
                <div>
                    <h3>Daftar Sub-Menu Pada Menu {{ucfirst(strtolower($menu->menu))}}</h3>
                    <div class="container fw-bold text-secondary">
                        <a href="{{ route('menu.index') }}" class="text-dark text-decoration-none">Menu</a>
                        <span class="mx-1">></span>
                        <span class="text-capitalize">{{ strtolower($menu->menu) }}</span>
                        <span class="mx-1">></span>
                        <a href="{{ route('submenu.index', $menu->id) }}" class="text-dark text-decoration-none">Sub-Menu</a>
                    </div>     
                </div>
                <div>
                    <a href="{{route('menu.index')}}" class="btn btn-dark">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <p class="fw-bold">Tambah Sub-Menu</p>
                    <div class="d-md-flex">
                        <a href="{{route('submenu.create',['menu' => $menu->id, 'tambah' => 0])}}" class="badge text-decoration-none text-bg-primary mx-1"><i class="bi-file-earmark me-1"></i>File</a>
                        <a href="{{route('submenu.create',['menu' => $menu->id, 'tambah' => 1])}}" class="badge text-decoration-none text-bg-warning mx-1"><i class="bi-image me-1"></i>Gambar</a>
                        <a href="{{route('submenu.create',['menu' => $menu->id, 'tambah' => 2])}}" class="badge text-decoration-none text-bg-secondary mx-1"><i class="bi-card-text me-1"></i>Halaman</a>
                        <a href="{{route('submenu.create',['menu' => $menu->id, 'tambah' => 3])}}" class="badge text-decoration-none text-bg-success mx-1"><i class="bi-diagram-3 me-1"></i>Identitas PD/UPT</a>
                        <a href="{{route('submenu.create',['menu' => $menu->id, 'tambah' => 4])}}" class="badge text-decoration-none text-bg-info mx-1"><i class="bi-globe me-1"></i>Link Medsos</a>
                    </div>
                </div>
                
                <hr class="mb-2">
                <div class="">
                    <p class="fw-bold">Tambah Sub-Menu Bertingkat</p>
                    <a href="{{route('submenu.create',['menu' => $menu->id, 'tambah' => 5])}}" class="badge text-decoration-none text-bg-dark mx-1"><i class="bi-grid-1x2 me-1"></i>Dropdown</a>
                </div>
                <hr>
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
                                    <td style="font-size: 12px">
                                        @if($item->type == 'dropdown')
                                            Jumlah Sub-Sub-Menu : {{$item->subSubMenus->count()}}
                                        @elseif($item->type == 'page')
                                            Berisi {{$item->filetype}}
                                        @elseif($item->type == 'link')
                                            {{$item->link}}
                                        @endif
                                    </td>
                                    <td class="row" style="font-size: 12px">
                                            @if($item->type == 'dropdown')
                                            <a href="{{ route('subsubmenu.index', ['submenu' => $item->id]) }}" class="btn btn-secondary mx-2 col-md-6" style="font-size: 12px">
                                                <i class="bi-eye"></i> Sub-Menu Bertingkat
                                            </a>
                                            @elseif($item->type == 'page')
                                            <a href="{{route('page.show',['id'=>$item->halaman->first()->id])}}" class="btn btn-secondary mx-2 col-md-6" style="font-size: 12px">
                                                <i class="bi bi-eye"></i> Sub-Menu
                                            </a>
                                            @elseif($item->type == 'link')
                                            <a href="#" target="_blank" rel="noopener noreferrer" class="btn btn-secondary mx-2 col-md-6" style="font-size: 12px">
                                                <i class="bi bi-eye"></i> Sub-Menu
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