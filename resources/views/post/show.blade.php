@extends('layouts.main')

@section('content')
@php
use Illuminate\Support\Str;

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

@endphp
<div class="bg-light container pt-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Post Title -->
            <h2 class="fw-bold">{{ $post->judul }}</h2>
            <div class=" text-muted mb-3" style="font-size: 12px">
                <i class="bi bi-person-circle me-2 "></i>
                <span>Editor: {{ $post->user->name ?? 'Anonymous'}}</span>
                <span class="mx-2 d-none d-md-inline">•</span>
                <br class="d-md-none d-sm-inline">
                <i class="bi bi-person-square me-2 "></i>
                <span>Kontributor: {{$post->contributor ?? 'Anonymous'}}</span>
                <span class="mx-2 d-none d-md-inline">•</span>
                <br class="d-md-none d-sm-inline">
                <i class="bi bi-tag-fill me-1"></i>
                <span>Kategori: {{ ucfirst($post->kategori->kategori) ?? 'Uncategorized'}}</span>
                <span class="mx-2 d-none d-md-inline">•</span>
                <br class="d-md-none d-sm-inline">
                <i class="bi bi-calendar me-2 "></i>
                <span>{{ \Carbon\Carbon::parse($post->created_at)->format('d F, Y') }}</span>
            </div>
            <!-- Post Content -->
            <div class="mb-4">
                <img src="{{ asset('storage/' . $post->media1) }}" alt="Post Image" class="w-100 img-fluid rounded mb-3">
                <p class="text-muted" style="font-size: 14px; text-align:justify;">{!!nl2br(makeLinksSmart($post->deskripsi)) !!}</p>
                @php
                    $mediaCount = collect([$post->media2, $post->media3, $post->media4])->filter()->count();
                    $colSize = $mediaCount > 0 ? 12 / $mediaCount : 12;
                @endphp

                <div class="row justify-content-evenly">
                    @if($post->media2)
                        <div class="col-md-{{ $colSize }}">
                            <img src="{{ asset('storage/' . $post->media2) }}" alt="Additional Image" class="h-100 img-fluid rounded mb-3" style="object-fit: cover" data-bs-toggle="modal" data-bs-target="#mediaModal" data-bs-image="{{ asset('storage/' . $post->media2) }}">
                        </div>
                    @endif
                    @if($post->media3)
                        <div class="col-md-{{ $colSize }}">
                            <img src="{{ asset('storage/' . $post->media3) }}" alt="Additional Image" class="h-100 img-fluid rounded mb-3" style="object-fit: cover" data-bs-toggle="modal" data-bs-target="#mediaModal" data-bs-image="{{ asset('storage/' . $post->media3) }}">
                        </div>
                    @endif
                    @if($post->media4)
                        <div class="col-md-{{ $colSize }}">
                            <img src="{{ asset('storage/' . $post->media4) }}" alt="Additional Image" class="h-100 img-fluid rounded mb-3" style="object-fit: cover" data-bs-toggle="modal" data-bs-target="#mediaModal" data-bs-image="{{ asset('storage/' . $post->media4) }}">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        @include('layouts.sidebar')
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">Detail Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="w-100 h-100" style="object-fit: contain" alt="Media">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
         const modal = document.getElementById('mediaModal');
         const modalImage = document.getElementById('modalImage');
 
         modal.addEventListener('show.bs.modal', function (event) {
             const button = event.relatedTarget; 
             const imageUrl = button.getAttribute('data-bs-image');
             modalImage.src = imageUrl; 
         });
     });
 </script>
@endsection


