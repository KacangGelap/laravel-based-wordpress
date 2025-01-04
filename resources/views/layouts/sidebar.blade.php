<div class="col-lg-4">
    <h5 class="fw-bold">Stay Connected</h5>
    <hr class="mb-3">
    <!-- Trending Tabs -->
    <ul class="nav nav-tabs" id="trendingTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="trending-tab" data-bs-toggle="tab" href="#trending" role="tab">Trending</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="latest-tab" data-bs-toggle="tab" href="#latest" role="tab">Latest</a>
        </li>
    </ul>
    <div class="tab-content mt-3">
        <!-- Trending Tab Content -->
        <div class="tab-pane fade" id="trending" role="tabpanel">
            {{-- Example trending content --}}
            <div class="d-flex mb-3">
                {{-- <img src="{{ $post->media1 }}" class="me-3 rounded" style="width: 70px; height: 70px;" alt="Trending Image">
                <div>
                    <a href="{{ route('post.view', $post->id) }}" class="fw-bold text-dark">{{ $post->judul }}</a>
                    <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($post->created_at)->format('F d, Y') }}</p>
                </div> --}}
            </div>
        </div>
        <!-- Latest Tab Content -->
        <div class="tab-pane fade show active" id="latest" role="tabpanel">
            @foreach ($latest as $item)
            <a href="{{route('post.view', ['post' => $item->id])}}" target="_blank" rel="noopener noreferrer">
                <div class="d-flex mb-3">
                    <img src="{{ $item->media1 }}" class="me-3 rounded" style="width: 70px; height: 70px;" alt="Latest Image">
                    <div>
                        <a href="{{ route('post.view', ['post' => $item->id]) }}" class="fw-bold text-dark">{{ $item->judul }}</a>
                        <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
