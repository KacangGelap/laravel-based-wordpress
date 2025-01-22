@extends('layouts.main')
@section('content')
    <div class="bg-light container pt-4">
        <h4>{{session('c') === 'submenu' ?$page->sub_menu : (session('c') === 'subsubmenu' ? $page->sub_sub_menu : $page->sub_sub_sub_menu) }}</h4>
        <div class="row">
            <div class="col-lg-8">
                @if ($page->type === 'id.pdupt')
                <div>
                    <table class="w-100">
                        <tbody>
                            <tr class="justify-content-between border-bottom">
                                <td class="col-md-6"><b>{{__('Nama Website')}}<b></td>
                                <td class="col-md-6 text-end">{{config( 'app.name', 'Website pemerintah kota Bontang')}}</td>
                            </tr>
                            <tr class="justify-content-between border-bottom">
                                <td class="col-md-6"><b>{{__('Alamat')}}<b></td>
                                <td class="col-md-6 text-end">{{$page->alamat}}</td>
                            </tr>
                            <tr class="justify-content-between border-bottom">
                                <td class="col-md-6"><b>{{__('No. Telp')}}<b></td>
                                <td class="col-md-6 text-end">{{$page->telp}}</td>
                            </tr>
                            <tr class="justify-content-between border-bottom">
                                <td class="col-md-6"><b>{{__('Alamat Surel')}}<b></td>
                                <td class="col-md-6 text-end">{{$page->email}}</td>
                            </tr>
                            <tr class="justify-content-between border-bottom">
                                <td class="col-md-6"><b>{{__('Website Resmi')}}<b></td>
                                <td class="col-md-6 text-end">{{$page->website}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex">
                    @if($page->instagram)
                    <a class="text-dark h1 me-2" href="https://instagram.com/{{$page->instagram}}" target="_blank" rel="noopener noreferrer"><i class="bi-instagram"></i></a>
                    @endif
                    @if($page->instagram)
                        <a class="text-dark h1 me-2" href="https://facebook.com/{{$page->facebook}}" target="_blank" rel="noopener noreferrer"><i class="bi-facebook"></i></a>
                    @endif
                </div>
                
                
                {!! $page->maps !!}
                @elseif($page->filetype === 'pdf')
                <iframe src="data:application/pdf;base64,{{ base64_encode($page->media) }}" class="min-vh-100 w-100"></iframe>
                @elseif ($page->filetype === 'foto')
                <img src="data:image/jpeg;base64,{{ base64_encode($page->media) }}" class="w-100">
                @else
                <!-- Image -->
                <a href="#imageModal" data-bs-toggle="modal">
                    <img src="data:image/jpeg;base64,{{ base64_encode($page->media) }}" height="250px" class="w-100" style="object-fit: cover">
                </a>

                <!-- Image description -->
                <p class="text-muted" style="font-size: 14px">{{ $page->text }}</p>

                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Detail Gambar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Full-sized Image in the Modal -->
                                <img src="data:image/jpeg;base64,{{ base64_encode($page->media) }}" class="w-100" style="object-fit: contain">
                            </div>
                        </div>
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>

@endsection