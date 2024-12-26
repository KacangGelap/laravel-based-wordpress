@extends('layouts.main')

@section('content')
<div class="bg-light container pt-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Post Title -->
            <h2 class="fw-bold">{{ $post->judul }}</h2>
            <div class="d-flex align-items-center text-muted mb-3">
                <i class="bi bi-person-circle me-2"></i>
                <span>{{ $post->user->name ?? 'Anonymous'}}</span>
                <span class="mx-2">•</span>
                <span>{{ ucfirst($post->kategori->kategori) ?? 'Uncategorized'}}</span>
                <span class="mx-2">•</span>
                <i class="bi bi-calendar me-2"></i>
                <span>{{ \Carbon\Carbon::parse($post->created_at)->format('F d, Y') }}</span>
            </div>
            <!-- Post Content -->
            <div class="mb-4">
                <img src="{{ $post->media1 }}" alt="Post Image" class="w-100 img-fluid rounded mb-3">
                <p class="text-muted">{{ $post->deskripsi1 }}</p>
                @if($post->media2)
                    <img src="{{ $post->media2 }}" alt="Additional Image" class="img-fluid rounded mb-3">
                    <p class="text-muted">{{ $post->deskripsi2 }}</p>
                @endif
                @if($post->media3)
                    <img src="{{ $post->media3 }}" alt="Additional Image" class="img-fluid rounded mb-3">
                    <p class="text-muted">{{ $post->deskripsi3 }}</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <h5 class="fw-bold">Stay Connected</h5>
            <hr class="mb-3">
            <!-- Trending Tabs -->
            <ul class="nav nav-tabs" id="trendingTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="trending-tab" data-bs-toggle="tab" href="#trending" role="tab">Trending</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="latest-tab" data-bs-toggle="tab" href="#latest" role="tab">Latest</a>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <!-- Trending Tab Content -->
                <div class="tab-pane fade show active" id="trending" role="tabpanel">
                    {{-- @foreach ($trending_posts as $trending) --}}
                        <div class="d-flex mb-3">
                            <img src="{{ $post->media1 }}" class="me-3 rounded" style="width: 70px; height: 70px;" alt="Trending Image">
                            <div>
                                <a href="{{ route('post.view', $post->id) }}" class="fw-bold text-dark">{{ $post->judul }}</a>
                                <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($post->created_at)->format('F d, Y') }}</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <img src="{{ $post->media1 }}" class="me-3 rounded" style="width: 70px; height: 70px;" alt="Trending Image">
                            <div>
                                <a href="{{ route('post.view', $post->id) }}" class="fw-bold text-dark">{{ $post->judul }}</a>
                                <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($post->created_at)->format('F d, Y') }}</p>
                            </div>
                        </div>
                    {{-- @endforeach --}} 
                </div>
                <!-- Latest Tab Content (similar to Trending) -->
                <div class="tab-pane fade" id="latest" role="tabpanel">
                    @foreach ($latest as $latest)
                        <div class="d-flex mb-3">
                            <img src="{{ $latest->media1 }}" class="me-3 rounded" style="width: 70px; height: 70px;" alt="Latest Image">
                            <div>
                                <a href="{{ route('post.view', $latest->id) }}" class="fw-bold text-dark">{{ $latest->judul }}</a>
                                <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($latest->created_at)->format('F d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
