@extends('layouts.main')

@section('content')
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
                <img src="{{ $post->media1 }}" alt="Post Image" class="w-100 img-fluid rounded mb-3">
                <p class="text-muted" style="font-size: 14px">{{ $post->deskripsi }}</p>
                @php
                    // Count the number of non-null media items
                    $mediaCount = collect([$post->media2, $post->media3, $post->media4])->filter()->count();
                    // Determine the column size based on the media count
                    $colSize = $mediaCount > 0 ? 12 / $mediaCount : 12; // Divide 12 by the count or default to 12
                @endphp

                <div class="row justify-content-evenly">
                    @if($post->media2)
                        <div class="col-md-{{ $colSize }}">
                            <img src="{{ $post->media2 }}" alt="Additional Image" class="img-fluid rounded mb-3">
                        </div>
                    @endif
                    @if($post->media3)
                        <div class="col-md-{{ $colSize }}">
                            <img src="{{ $post->media3 }}" alt="Additional Image" class="img-fluid rounded mb-3">
                        </div>
                    @endif
                    @if($post->media4)
                        <div class="col-md-{{ $colSize }}">
                            <img src="{{ $post->media4 }}" alt="Additional Image" class="img-fluid rounded mb-3">
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- Sidebar -->
        @include('layouts.sidebar')
    </div>
</div>
@endsection
