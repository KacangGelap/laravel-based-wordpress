@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{ isset($data) ? __('Edit Halaman') : __('Tambah Halaman') }}</h4>
                    @php
                        $routeName = \Route::current()->getName();
                        $submenuRoute = $routeName === 'submenu.create' || $routeName === 'submenu.edit';
                        $subsubmenuRoute = $routeName === 'subsubmenu.create' || $routeName === 'subsubmenu.edit';
                        $subsubsubmenuRoute = $routeName === 'subsubsubmenu.create' || $routeName === 'subsubsubmenu.edit';
                        // Get session data for the menu and submenu IDs
                        $menuId = session('menu_id');
                        $subMenuId = session('sub_menu_id');
                        $subSubMenuId = session('sub_sub_menu_id');
                        $subSubSubMenuId = session('sub_sub_sub_menu_id');
                        // Determine the return URL based on available session data
                        if ($menuId && $submenuRoute) {
                            $backUrl = route('submenu.index', $menuId);
                        } elseif ($subMenuId && $subsubmenuRoute) {
                            $backUrl = route('subsubmenu.index', $subMenuId);
                        } elseif ($subSubMenuId && $subsubsubmenuRoute) {
                            $backUrl = route('subsubsubmenu.index', $subSubMenuId);
                        } else {
                            $backUrl = route('subsubsubsubmenu.index', $subSubSubMenuId);
                        }
                    @endphp
                    <a href="{{ $backUrl }}" class="btn btn-dark">Kembali</a>
                </div>

                <div class="card-body">
                    @php
                        // Get the current route name
                        $routeName = Route::current()->getName();
                        
                        // Determine if we are editing or creating
                        $isEditing = isset($data);
                        
                        // Set the proper route for editing
                        if ($isEditing) {
                            // If editing, use the update route for submenu, subsubmenu, or subsubsubmenu
                            if ($routeName == 'submenu.edit') {
                                $routeAction = route('submenu.update', ['menu'=>$data->menu->id,'submenu'=>$data->id]);
                            } elseif ($routeName == 'subsubmenu.edit') {
                                $routeAction = route('subsubmenu.update', ['submenu'=>$data->submenu->id, 'subsubmenu'=>$data->id]);
                            } elseif ($routeName == 'subsubsubmenu.edit') {
                                $routeAction = route('subsubsubmenu.update',  ['subsubmenu'=>$data->subsubmenu->id, 'subsubsubmenu'=>$data->id]);
                            } else {
                                $routeAction = route('subsubsubsubmenu.update',  ['subsubsubmenu'=>$data->subsubsubmenu->id, 'subsubsubsubmenu'=>$data->id]);
                            }
                        } else {
                            // If creating, use the store route for submenu, subsubmenu, or subsubsubmenu
                            if ($routeName == 'submenu.create') {
                                $routeAction = route('submenu.store', session('menu_id'));
                            } elseif ($routeName == 'subsubmenu.create') {
                                $routeAction = route('subsubmenu.store', session('sub_menu_id'));
                            } elseif ($routeName == 'subsubsubmenu.create') {
                                $routeAction = route('subsubsubmenu.store', session('sub_sub_menu_id'));
                            } else {
                                $routeAction = route('subsubsubsubmenu.store', session('sub_sub_sub_menu_id'));
                            }
                        }
                    @endphp
                    <form method="POST" action="{{$routeAction}}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($data))
                            @method('PUT')
                        @endif
                        <div class="row mb-3">
                            <label for="judul" class="col-md-4 col-form-label text-md-end">Judul {{ Route::current()->getName() == 'submenu.create' || Route::current()->getName() == 'submenu.edit' ? 'Sub-Menu' : (Route::current()->getName() == 'subsubmenu.create' || Route::current()->getName() == 'subsubmenu.edit' ? 'Sub-Sub-Menu' : (Route::current()->getName() == 'subsubmenu.create' || Route::current()->getName() == 'subsubmenu.edit' ? 'Sub-Sub-Sub-Menu' : 'Sub-Sub-Sub-Sub-Menu')) }}<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ $data->sub_menu ?? $data->sub_sub_menu ?? $data->sub_sub_sub_menu ?? $data->sub_sub_sub_sub_menu ?? old('judul') }}" required autocomplete="judul" autofocus>

                                @error('judul')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="text" class="col-md-4 col-form-label text-md-end">Masukkan Teks<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <textarea class="form-control border border-dark @error('text') is-invalid @enderror" rows="4" name="text" required>{{$data->text ?? old('text')}}</textarea>
                                @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="media" class="col-md-4 col-form-label text-md-end">Masukkan Gambar / File Pdf<span class="text-danger" required>*</span></label>

                            <div class="col-md-6">
                                <input id="media" type="file" class="form-control @error('media') is-invalid @enderror" name="media" value="{{ old('media') }}" {{!isset($data) ? 'required': ''}} autocomplete="media" autofocus>

                                @error('media')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">File Tambahan 1 (opsional)</label>
                            <div class="col-md-6">
                                <div class="card shadow-sm border position-relative">
                                    <label for="tambahan1" id="label-tambahan1" 
                                        class="d-flex flex-column justify-content-center align-items-center"
                                        style="height: 200px; cursor: pointer;
                                            background-image: url('{{ isset($data->tambahan1) ? "/storage/$data->tambahan1" : '' }}');
                                            background-size: cover;
                                            background-position: center;">
                                        
                                        <input type="file" id="tambahan1" name="tambahan1" class="d-none @error('tambahan1') is-invalid @enderror">
                                        
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <p class="btn btn-primary m-0 px-3 py-1" id="text-tambahan1">Upload File</p>
                                        </div>
                                    </label>

                                    {{-- Checkbox Hapus --}}
                                    <div class="d-flex form-check justify-content-center bg-light py-2">
                                        <input class="form-check-input me-2" type="checkbox" name="hapus_tambahan1" id="hapus_tambahan1" value="1"
                                            {{ empty($data->tambahan1) ? 'disabled' : '' }}>
                                        <label class="form-check-label small {{ empty($data->tambahan1) ? 'text-muted' : '' }}" for="hapus_tambahan1">
                                            Hapus File
                                        </label>
                                    </div>

                                    @error('tambahan1')
                                        <span class="invalid-feedback d-block text-center" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">File Tambahan 2 (opsional)</label>
                            <div class="col-md-6">
                                <div class="card shadow-sm border position-relative">
                                    <label for="tambahan2" id="label-tambahan2" 
                                        class="d-flex flex-column justify-content-center align-items-center"
                                        style="height: 200px; cursor: pointer;
                                            background-image: url('{{ isset($data->tambahan2) ? "/storage/$data->tambahan2" : '' }}');
                                            background-size: cover;
                                            background-position: center;">
                                        
                                        <input type="file" id="tambahan2" name="tambahan2" class="d-none @error('tambahan2') is-invalid @enderror">
                                        
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <p class="btn btn-primary m-0 px-3 py-1" id="text-tambahan2">Upload File</p>
                                        </div>
                                    </label>

                                    {{-- Checkbox Hapus --}}
                                    <div class="d-flex form-check justify-content-center bg-light py-2">
                                        <input class="form-check-input me-2" type="checkbox" name="hapus_tambahan2" id="hapus_tambahan2" value="1"
                                            {{ empty($data->tambahan2) ? 'disabled' : '' }}>
                                        <label class="form-check-label small {{ empty($data->tambahan2) ? 'text-muted' : '' }}" for="hapus_tambahan2">
                                            Hapus File
                                        </label>
                                    </div>

                                    @error('tambahan2')
                                        <span class="invalid-feedback d-block text-center" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">File Tambahan 3 (opsional)</label>
                            <div class="col-md-6">
                                <div class="card shadow-sm border position-relative">
                                    <label for="tambahan3" id="label-tambahan3" 
                                        class="d-flex flex-column justify-content-center align-items-center"
                                        style="height: 200px; cursor: pointer;
                                            background-image: url('{{ isset($data->tambahan3) ? "/storage/$data->tambahan3" : '' }}');
                                            background-size: cover;
                                            background-position: center;">
                                        
                                        <input type="file" id="tambahan3" name="tambahan3" class="d-none @error('tambahan3') is-invalid @enderror">
                                        
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <p class="btn btn-primary m-0 px-3 py-1" id="text-tambahan3">Upload File</p>
                                        </div>
                                    </label>

                                    {{-- Checkbox Hapus --}}
                                    <div class="d-flex form-check justify-content-center bg-light py-2">
                                        <input class="form-check-input me-2" type="checkbox" name="hapus_tambahan3" id="hapus_tambahan3" value="1"
                                            {{ empty($data->tambahan3) ? 'disabled' : '' }}>
                                        <label class="form-check-label small {{ empty($data->tambahan3) ? 'text-muted' : '' }}" for="hapus_tambahan3">
                                            Hapus File
                                        </label>
                                    </div>

                                    @error('tambahan3')
                                        <span class="invalid-feedback d-block text-center" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
			            <div class="row mb-3">
                            <label for="link" class="col-md-4 col-form-label text-md-end">Link Youtube</label>
                            <div class="col-md-6">
                                <input id="link" type="text" class="form-control @error('link') is-invalid @enderror"
                                    name="link" value="{{ isset($data->link) ? "https://youtube.com/watch?v=$data->link" : old('link') }}" autocomplete="link" autofocus>

                                @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                {{-- Checkbox hapus link --}}
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="hapus_link" name="hapus_link" value="1"
                                        {{ empty($data->link) ? 'disabled' : '' }}>
                                    <label class="form-check-label {{ empty($data->link) ? 'text-muted' : '' }}" for="hapus_link">
                                        Hapus link YouTube
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{isset($data) ? __('Edit') : __('Tambah')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('tambahan1').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih file tambahan 1';
        document.getElementById('text-tambahan1').textContent = fileName;
        document.getElementById('label-tambahan1').style.backgroundImage = 'none';
    });

    document.getElementById('tambahan2').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih file tambahan 2';
        document.getElementById('text-tambahan2').textContent = fileName;
        document.getElementById('label-tambahan2').style.backgroundImage = 'none';
    });

    document.getElementById('tambahan3').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Pilih file tambahan 3';
        document.getElementById('text-tambahan3').textContent = fileName;
        document.getElementById('label-tambahan3').style.backgroundImage = 'none';
    });
</script>
@endsection
