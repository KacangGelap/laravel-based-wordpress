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
                        // Get session data for the menu and submenu IDs
                        $menuId = session('menu_id');
                        $subMenuId = session('sub_menu_id');
                        $subSubMenuId = session('sub_sub_menu_id');
                        
                        // Determine the return URL based on available session data
                        if ($menuId && $submenuRoute) {
                            $backUrl = route('submenu.index', $menuId);
                        } elseif ($subMenuId && $subsubmenuRoute) {
                            $backUrl = route('subsubmenu.index', $subMenuId);
                        } else {
                            $backUrl = route('subsubsubmenu.index', $subSubMenuId);
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
                            } else {
                                $routeAction = route('subsubsubmenu.update',  ['subsubmenu'=>$data->subsubmenu->id, 'subsubsubmenu'=>$data->id]);
                            }
                        } else {
                            // If creating, use the store route for submenu, subsubmenu, or subsubsubmenu
                            if ($routeName == 'submenu.create') {
                                $routeAction = route('submenu.store', session('menu_id'));
                            } elseif ($routeName == 'subsubmenu.create') {
                                $routeAction = route('subsubmenu.store', session('sub_menu_id'));
                            } else {
                                $routeAction = route('subsubsubmenu.store', session('sub_sub_menu_id'));
                            }
                        }
                    @endphp
                    <form method="POST" action="{{$routeAction}}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($data))
                            @method('PUT')
                        @endif
                        <div class="row mb-3">
                            <label for="judul" class="col-md-4 col-form-label text-md-end">Judul {{Route::current()->getName() == 'submenu.create' ? 'Sub-Menu' : (Route::current()->getName() == 'subsubmenu.create' ? 'Sub-Sub-Menu' : 'Sub-Sub-Sub-Menu')}}<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ $data->sub_menu ?? $data->sub_sub_menu ?? $data->sub_sub_sub_menu ?? old('judul') }}" required autocomplete="judul" autofocus>

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
                            <label for="media" class="col-md-4 col-form-label text-md-end">Masukkan Gambar / File Pdf<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="media" type="file" class="form-control @error('media') is-invalid @enderror" name="media" value="{{ old('media') }}" {{!isset($data) ? 'required' : ''}} autocomplete="media" autofocus>

                                @error('media')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tambahan1" class="col-md-4 col-form-label text-md-end">Masukkan Gambar tambahan (opsional)</label>

                            <div class="col-md-6">
                                <input id="tambahan1" type="file" class="form-control @error('tambahan1') is-invalid @enderror" name="tambahan1" value="{{ old('tambahan1') }}" autocomplete="tambahan1" autofocus>

                                @error('tambahan1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tambahan2" class="col-md-4 col-form-label text-md-end">Masukkan Gambar tambahan (opsional)</label>

                            <div class="col-md-6">
                                <input id="tambahan2" type="file" class="form-control @error('tambahan2') is-invalid @enderror" name="tambahan2" value="{{ old('tambahan2') }}" autocomplete="tambahan2" autofocus>

                                @error('tambahan2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tambahan3" class="col-md-4 col-form-label text-md-end">Masukkan Gambar tambahan (opsional)</label>

                            <div class="col-md-6">
                                <input id="tambahan3" type="file" class="form-control @error('tambahan3') is-invalid @enderror" name="tambahan3" value="{{ old('tambahan3') }}" autocomplete="tambahan3" autofocus>

                                @error('tambahan3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
@endsection
