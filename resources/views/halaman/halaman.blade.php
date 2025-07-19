@extends('layouts.main')
@section('content') 
    <div class="bg-light container min-vh-100 pt-4">
        @php
use Illuminate\Support\Str;

if (!function_exists('makeLinksSmart')) {
function makeLinksSmart($text) {
    $placeholders = [];

    // 1. Convert Markdown-style links [label](url)
    $text = preg_replace_callback(
        '/\[(.*?)\]\((https?:\/\/[^\s<]+)\)/i',
        function ($matches) use (&$placeholders) {
            $label = e($matches[1]);
            $url = $matches[2];

            if (!Str::startsWith($url, ['http://', 'https://'])) {
                return e($matches[0]);
            }

            $placeholder = '[[[LINK_' . count($placeholders) . ']]]';
            $placeholders[$placeholder] = '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer">' . $label . '</a>';
            return $placeholder;
        },
        $text
    );

    // 2. Escape the full remaining text
    $text = e($text);

    // 3. Convert plain URLs to clickable links
    $text = preg_replace_callback(
        '~(https?://[^\s<]+)~i',
        function ($matches) {
            $url = $matches[1];
            $trailing = '';

            if (preg_match('/[.,!?)]+$/', $url, $trailMatch)) {
                $trailing = $trailMatch[0];
                $url = substr($url, 0, -strlen($trailing));
            }

            return '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer">'
                . e($url) . '</a>' . e($trailing);
        },
        $text
    );

    // 4. Replace placeholders back with real <a> tags
    $text = str_replace(array_keys($placeholders), array_values($placeholders), $text);

    return $text;
}
}
        @endphp
        <div class="row">
            <div class="col-lg-8">
                <h4>{{$page->sub_sub_sub_sub_menu ?? $page->sub_sub_sub_menu ?? $page->sub_sub_menu ?? $page->sub_menu }}</h4>
                <hr class="mb-4">
                @if ($page->type === 'id.pdupt')
                    <div>
                        <table class="w-75">
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="col-md-4"><b>{{__('Nama Website')}}<b></td>
                                    <td class="col-md-8">{{config( 'app.name', 'Website pemerintah kota Bontang')}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="col-md-4"><b>{{__('Alamat')}}<b></td>
                                    
                                    <td class="col-md-8">{{$page->alamat}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="col-md-4"><b>{{__('No. Telp')}}<b></td>
                                    
                                    <td class="col-md-8">{{$page->telp}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="col-md-4"><b>{{__('No. WhatsApp')}}<b></td>
                                    
                                    <td class="col-md-8">{{$page->wa}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="col-md-4"><b>{{__('No. Fax')}}<b></td>
                                    
                                    <td class="col-md-8">{{$page->fax}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="col-md-4"><b>{{__('Alamat Surel')}}<b></td>
                                    
                                    <td class="col-md-8">{{$page->email}}</td>
                                </tr>
                                <tr class="  border-bottom">
                                    <td class="col-md-4"><b>{{__('Website Resmi')}}<b></td>
                                    
                                    <td class="col-md-8">{{$page->website}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="col-md-4"><b>{{__('Kritik dan Saran')}}<b></td>
                                    
                                    <td class="col-md-8"><a class="btn btn-primary" href="{{$page->link}}" target="_blank" rel="noopener noreferrer">Klik Disini</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex">
                        @if($page->youtube)
                            <a class="text-danger h1 me-2" href="https://youtube.com/{{$page->youtube}}" target="_blank" rel="noopener noreferrer"><i class="bi-youtube"></i></a>
                        @endif
                        @if($page->instagram)
                            <a class="text-white h1 me-2" href="https://instagram.com/{{$page->instagram}}" target="_blank" rel="noopener noreferrer"><i class="bi-instagram" style="background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);-webkit-background-clip: text;-webkit-text-fill-color: transparent;display: inline-block;"></i></a>
                        @endif
                        @if($page->facebook)
                            <a class="text-primary h1 me-2" href="https://facebook.com/{{$page->facebook}}" target="_blank" rel="noopener noreferrer"><i class="bi-facebook"></i></a>
                        @endif
                        @if($page->x)
                            <a class="text-dark h1 me-2" href="https://x.com/{{$page->x}}" target="_blank" rel="noopener noreferrer"><i class="bi-twitter-x"></i></a>
                        @endif
                        @if($page->tiktok)
                            <a class="text-dark h1 me-2" href="https://tiktok.com/{{$page->tiktok}}" target="_blank" rel="noopener noreferrer">
                                <i class="bi-tiktok" style="filter: drop-shadow(-2px -2px 0 #24f6f0) brightness(110%) drop-shadow(2px 2px 0 #fe2d52) brightness(110%);"></i>
                            </a>                                                                                 
                        @endif
                    </div>
                
                    <div class="d-flex align-items-stretch">
                        {!! $page->maps !!}
                    </div>
                @elseif($page->filetype === 'pdf')
                    {{-- PDF --}}
                    <iframe src="{{ asset('storage/'.$page->media) }}" class="min-vh-100 w-100"></iframe>
                @elseif ($page->filetype === 'foto')
                    {{-- Foto --}}
                    <img src="{{ asset('storage/'.$page->media) }}" class="w-100 mb-4">
                @else
                    {{-- Halaman --}}
                    <p class="text-muted" style="font-size: 14px;text-align:justify">{!! nl2br(makeLinksSmart($page->text)) !!}</p>
                    @if(\Illuminate\Support\Facades\File::mimeType(public_path('storage/'.$page->media)) === 'application/pdf')
                        <iframe src="{{ asset('storage/'.$page->media) }}" class="min-vh-100 w-100 mb-4"></iframe>
                    @else
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/'.$page->media) }}">
                                <img src="{{ asset('storage/'.$page->media) }}" class="w-100 py-4" style="object-fit: cover">
                        </a>
                    
                    @endif
                    @if($page->tambahan1)
                         @if(\Illuminate\Support\Facades\File::mimeType(public_path('storage/'.$page->tambahan1)) === 'application/pdf')
                            <iframe src="{{ asset('storage/'.$page->tambahan1) }}" class="min-vh-100 w-100 mb-4"></iframe>
                        @else
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/'.$page->tambahan1) }}">
                                    <img src="{{ asset('storage/'.$page->tambahan1) }}" class="w-100 py-4" style="object-fit: cover">
                            </a>
                        
                        @endif
                    @endif
                    @if($page->tambahan2)
                         @if(\Illuminate\Support\Facades\File::mimeType(public_path('storage/'.$page->tambahan2)) === 'application/pdf')
                            <iframe src="{{ asset('storage/'.$page->tambahan2) }}" class="min-vh-100 w-100 mb-4"></iframe>
                        @else
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/'.$page->tambahan2) }}">
                                    <img src="{{ asset('storage/'.$page->tambahan2) }}" class="w-100 py-4" style="object-fit: cover">
                            </a>
                        @endif
                    @endif
                    @if($page->tambahan3)
                         @if(\Illuminate\Support\Facades\File::mimeType(public_path('storage/'.$page->tambahan3)) === 'application/pdf')
                            <iframe src="{{ asset('storage/'.$page->tambahan3) }}" class="min-vh-100 w-100 mb-4"></iframe>
                        @else
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/'.$page->tambahan3) }}">
                                    <img src="{{ asset('storage/'.$page->tambahan3) }}" class="w-100 py-4" style="object-fit: cover">
                            </a>
                        @endif
                    @endif
                    @if($page->link)
                        <iframe src="https://youtube.com/embed/{{$page->link}}" class="w-100" height="450px"></iframe>
                    @endif
                    {{-- Modal for Images --}}
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Detail Gambar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Full-sized Image in the Modal -->
                                <img id="modalImage" class="w-100 h-100" style="object-fit: contain" />
                            </div>
                        </div>
                    </div>
                    </div>

                    <script>
                    // When the modal is shown, we update the image inside the modal
                    const imageModal = document.getElementById('imageModal');
                    imageModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget; // Button that triggered the modal
                        const imageSrc = button.getAttribute('data-bs-image'); // Get the image source from the data attribute
                        const modalImage = imageModal.querySelector('#modalImage'); // Find the image element in the modal
                        modalImage.src = imageSrc; // Set the image source in the modal
                    });
                    </script>
                @endif
            </div>
            <!-- Sidebar -->
            @include('layouts.sidebar')
        </div>
    </div>

@endsection
