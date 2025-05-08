@extends('layouts.dashboard')

@section('content')
<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-md-flex card-header justify-content-between">
                    <h4>{{ isset($data) ?'Isi Identitas PD/UPT' : 'Edit Identitas PD/UPT'}}</h4>
                    @php
                    // Get session data for the menu and submenu IDs
                    $menuId = session('menu_id');
                    $subMenuId = session('sub_menu_id');
                    $subSubMenuId = session('sub_sub_menu_id');
                    $subSubSubMenuId = session('sub_sub_sub_menu_id');
                    // Determine the return URL based on available session data
                    if ($menuId) {
                        $backUrl = route('submenu.index', $menuId);
                    } elseif ($subMenuId) {
                        $backUrl = route('subsubmenu.index', $subMenuId);
                    } elseif ($subSubMenuId) {
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
                    <form method="POST" action="{{$routeAction}}">
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
                            <label for="alamat" class="col-md-4 col-form-label text-md-end">Alamat Lengkap<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ $data->alamat ?? old('alamat') }}" required autocomplete="alamat" autofocus>

                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="telp" class="col-md-4 col-form-label text-md-end">Nomor Telepon<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="telp" type="text" class="form-control @error('telp') is-invalid @enderror" name="telp" value="{{ $data->telp ?? old('telp') }}" required autocomplete="telp" autofocus>

                                @error('telp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="wa" class="col-md-4 col-form-label text-md-end">Nomor WhatsApp (CS)<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="wa" type="number" class="form-control @error('wa') is-invalid @enderror" name="wa" value="{{ $data->wa ?? old('wa') }}" required autocomplete="wa" autofocus>

                                @error('wa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fax" class="col-md-4 col-form-label text-md-end">Nomor FAX (opsional)</label>

                            <div class="col-md-6">
                                <input id="fax" type="text" class="form-control @error('fax') is-invalid @enderror" name="fax" value="{{ $data->fax ?? old('fax') }}" autocomplete="fax" autofocus>

                                @error('fax')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Alamat Surel<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data->email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="website" class="col-md-4 col-form-label text-md-end">URL Website<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ $data->website ?? old('website') }}" required autocomplete="website" autofocus placeholder="https://nama-website.bontangkota.go.id">

                                @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="link" class="col-md-4 col-form-label text-md-end">GForm Hub. Kami (opsional)</label>

                            <div class="col-md-6">
                                <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ $data->link ?? old('link') }}" autocomplete="link" autofocus placeholder="https://forms.gle/C0nt0HiD70rm">

                                @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <h4>Sosial Media (opsional)</h4>
                        <div class="row mb-3">
                            <label for="instagram" class="col-md-4 col-form-label text-md-end">Link Profile Instagram PD / UPT</label>

                            <div class="col-md-6">
                                <input id="instagram" type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram" value="{{ isset($data->instagram) ? 'https://instagram.com/'.$data->instagram : old('instagram') }}" autocomplete="instagram" autofocus>

                                @error('instagram')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="facebook" class="col-md-4 col-form-label text-md-end">Link Profile Facebook PD / UPT</label>

                            <div class="col-md-6">
                                <input id="facebook" type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook" value="{{ isset($data->facebook) ? 'https://facebook.com/'.$data->facebook : old('facebook') }}" autocomplete="facebook" autofocus>

                                @error('facebook')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="youtube" class="col-md-4 col-form-label text-md-end">Link Channel YouTube PD / UPT</label>

                            <div class="col-md-6">
                                <input id="youtube" type="text" class="form-control @error('youtube') is-invalid @enderror" name="youtube" value="{{ isset($data->youtube) ? 'https://youtube.com/'.$data->youtube : old('youtube') }}" autocomplete="youtube" autofocus>

                                @error('youtube')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tiktok" class="col-md-4 col-form-label text-md-end">Link Profile TikTok PD / UPT</label>

                            <div class="col-md-6">
                                <input id="tiktok" type="text" class="form-control @error('tiktok') is-invalid @enderror" name="tiktok" value="{{ isset($data->tiktok) ? 'https://tiktok.com/'.$data->tiktok : old('tiktok') }}" autocomplete="tiktok" autofocus>

                                @error('tiktok')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="x" class="col-md-4 col-form-label text-md-end">Link Profile X (Twitter) PD / UPT</label>

                            <div class="col-md-6">
                                <input id="x" type="text" class="form-control @error('x') is-invalid @enderror" name="x" value="{{ isset($data->x) ? 'https://x.com/'.$data->x : old('x') }}" autocomplete="x" autofocus>

                                @error('x')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <h4>Frame Google Maps (opsional)</h4>
                        <div class="row mb-3">
                            <label for="maps" class="col-md-4 col-form-label text-md-end">Google Map Embed</label>

                            <div class="col-md-6">
                                <input id="maps" type="text" class="form-control @error('maps') is-invalid @enderror" name="maps" value="{{ $data->maps ?? old('maps') }}" autocomplete="maps" autofocus>

                                @error('maps')
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
