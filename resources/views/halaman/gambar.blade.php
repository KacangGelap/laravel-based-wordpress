@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{ isset($data) ? 'Edit Gambar' : 'Tambah Gambar'}}</h4>
                    @php
                        $routeName = Route::current()->getName();
                        $submenu = $routeName == 'submenu.create' || $routeName == 'submenu.edit';
                        $subsubmenu = $routeName == 'subsubmenu.create' || $routeName == 'subsubmenu.edit';
                        $subsubsubmenu = $routeName == 'subsubsubmenu.create' || $routeName == 'subsubsubmenu.edit';
                        // Get session data for the menu and submenu IDs
                        $menuId = session('menu_id');
                        $subMenuId = session('sub_menu_id');
                        $subSubMenuId = session('sub_sub_menu_id');
                        $subSubSubMenuId = session('sub_sub_sub_menu_id');
                        // Determine the return URL based on available session data
                        if ($menuId && $submenu) {
                            $backUrl = route('submenu.index', $menuId);
                        } elseif ($subMenuId && $subsubmenu) {
                            $backUrl = route('subsubmenu.index', $subMenuId);
                        } elseif($subSubMenuId && $subsubsubmenu) {
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
                            <label for="judul" class="col-md-4 col-form-label text-md-end">Judul {{ Route::current()->getName() == 'submenu.create' || Route::current()->getName() == 'submenu.edit' ? 'Sub-Menu' : (Route::current()->getName() == 'subsubmenu.create' || Route::current()->getName() == 'subsubmenu.edit' ? 'Sub-Sub-Menu' : (Route::current()->getName() == 'subsubmenu.create' || Route::current()->getName() == 'subsubmenu.edit' ? 'Sub-Sub-Sub-Menu' : 'Sub-Sub-Sub-Sub-Menu')) }}</label>

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
                            <label for="image" class="col-md-4 col-form-label text-md-end">Masukkan Gambar</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"  {{!isset($data) ? 'required' : ''}} autocomplete="image" autofocus>

                                @error('image')
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
