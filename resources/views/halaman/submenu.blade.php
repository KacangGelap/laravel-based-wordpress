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
                        @if($isExists === false && strcasecmp($menu->menu, "tentang") == 0)<a href="{{route('submenu.create',['menu' => $menu->id, 'tambah' => 3])}}" class="badge text-decoration-none text-bg-success mx-1"><i class="bi-diagram-3 me-1"></i>Identitas PD/UPT</a>@endif
                        <a href="{{route('submenu.create',['menu' => $menu->id, 'tambah' => 4])}}" class="badge text-decoration-none text-bg-info mx-1"><i class="bi-globe me-1"></i>Link Medsos / GForm</a>
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
                                            Halaman {{$item->filetype}}
                                        @elseif($item->type == 'link')
                                            @if($item->filetype == 'video')
                                                {{__('Berisi Link YouTube')}}
                                            @else
                                                {{$item->link}}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="d-md-flex" style="font-size: 12px">
                                            @if($item->type == 'dropdown')
                                            <a href="{{ route('subsubmenu.index', ['submenu' => $item->id]) }}" class="btn btn-secondary mx-2 col" style="font-size: 12px">
                                                <i class="bi-eye"></i> <span class="d-none d-md-inline">Sub-Menu Bertingkat</span>
                                            </a>
                                            <a href="{{ route('submenu.edit', ['menu'=>$item->menu->id, 'submenu' => $item->id, 'edit'=>5]) }}" class="btn btn-warning mx-2 col" style="font-size: 12px">
                                                <i class="bi-pencil"></i> <span class="d-none d-md-inline">Edit Sub-Menu</span>
                                            </a>
                                            
                                            @elseif($item->type == 'page')
                                            <a href="{{route('page.show',['id'=>$item->halaman->first()->id])}}" class="btn btn-secondary mx-2 col" style="font-size: 12px">
                                                <i class="bi bi-eye"></i> <span class="d-none d-md-inline">Sub-Menu</span>
                                            </a>
                                                @if($item->filetype == 'pdf')
                                                    <a href="{{ route('submenu.edit', ['menu'=>$item->menu->id, 'submenu' => $item->id, 'edit'=>0]) }}" class="btn btn-warning mx-2 col" style="font-size: 12px">
                                                        <i class="bi-pencil"></i> <span class="d-none d-md-inline">Edit Sub-Menu</span>
                                                    </a>
                                                @elseif($item->filetype == 'foto')
                                                    <a href="{{ route('submenu.edit', ['menu'=>$item->menu->id, 'submenu' => $item->id, 'edit'=>1]) }}" class="btn btn-warning mx-2 col" style="font-size: 12px">
                                                        <i class="bi-pencil"></i> <span class="d-none d-md-inline">Edit Sub-Menu</span>
                                                    </a>
                                                @else
                                                <a href="{{ route('submenu.edit', ['menu'=>$item->menu->id, 'submenu' => $item->id, 'edit'=>2]) }}" class="btn btn-warning mx-2 col" style="font-size: 12px">
                                                    <i class="bi-pencil"></i> <span class="d-none d-md-inline">Edit Sub-Menu</span>
                                                </a>
                                                @endif
                                            @elseif($item->type == 'id.pdupt')
                                                <a href="{{route('page.show',['id'=>$item->halaman->first()->id])}}" class="btn btn-secondary mx-2">
                                                    <i class="bi bi-eye"></i> <span class="d-none d-md-inline">Sub-Sub-Menu</span>
                                                </a>
                                                <a href="{{ route('submenu.edit', ['menu'=>$item->menu->id, 'submenu' => $item->id, 'edit'=>3]) }}" class="btn btn-warning mx-2 col" style="font-size: 12px">
                                                    <i class="bi-pencil"></i> <span class="d-none d-md-inline">Edit Sub-Menu</span>
                                                </a>
                                            @elseif($item->type == 'link')
                                                @if($item->filetype == 'video')
                                                <a href="http://youtu.be/{{$item->link}}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary mx-2 col"style="font-size: 12px">
                                                    <i class="bi bi-eye"></i> <span class="d-none d-md-inline">Sub-Menu</span>
                                                </a>
                                                @else
                                                <a href="{{$item->link}}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary mx-2 col-md-6" style="font-size: 12px">
                                                    <i class="bi bi-eye"></i> <span class="d-none d-md-inline">Sub-Menu</span>
                                                </a>
                                                @endif
                                                <a href="{{ route('submenu.edit', ['menu'=>$item->menu->id, 'submenu' => $item->id, 'edit'=>4]) }}" class="btn btn-warning mx-2 col" style="font-size: 12px">
                                                    <i class="bi-pencil"></i> <span class="d-none d-md-inline">Edit Sub-Menu</span>
                                                </a>
                                            @endif
                                            <button class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item->id }}">
                                                <i class="bi-trash"></i>
                                            </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    @foreach ($submenu as $item)
        <form id="hapus-{{ $item->id }}" action="{{ route('submenu.delete', ['menu'=>$item->menu->id, 'submenu'=>$item->id]) }}" method="POST" class="d-none">
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