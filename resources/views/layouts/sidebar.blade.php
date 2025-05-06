<div class="col-lg-4">
    @if(\Route::current()->getName() !== 'page.show')
    <!-- Trending Tabs -->
    <ul class="nav nav-tabs" id="trendingTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="latest-tab" data-bs-toggle="tab" href="#latest" role="tab">Berita Terkini</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="trending-tab" data-bs-toggle="tab" href="#trending" role="tab">Berita Trending</a>
        </li>
    </ul>
    <div class="tab-content mt-3">
        <!-- Trending Tab Content -->
        <div class="tab-pane fade" id="trending" role="tabpanel">
            {{-- Example trending content --}}
            @foreach ($trending as $item)
            <a href="{{route('post.view', ['post' => $item->id])}}" target="_blank" rel="noopener noreferrer">
                <div class="d-flex mb-3">
                    <img src="{{ asset('storage/'.$item->media1) }}" class="me-3 rounded" style="width: 70px; height: 70px;" alt="Trending Image">
                    <div>
                        <a href="{{ route('post.view', ['post' => $item->id]) }}" class="fw-bold text-dark">{{ $item->judul }}</a>
                        <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <!-- Latest Tab Content -->
        <div class="tab-pane fade show active" id="latest" role="tabpanel">
            @foreach ($latest as $item)
            <a href="{{route('post.view', ['post' => $item->id])}}" target="_blank" rel="noopener noreferrer">
                <div class="d-flex mb-3">
                    <img src="{{ asset('storage/'.$item->media1) }}" class="me-3 rounded" style="width: 70px; height: 70px;" alt="Latest Image">
                    <div>
                        <a href="{{ route('post.view', ['post' => $item->id]) }}" class="fw-bold text-dark">{{ $item->judul }}</a>
                        <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
    <h5 class="fw-bold pt-4">Link Terkait</h5>
    <hr>
    <div class="tab-content mt-3">
        <!-- Link Terkait Tab Content -->
        <div class="tab-pane fade show active" id="link" role="tabpanel">
            <div class="row mb-3 align-items-center justify-content-center">
		
                @foreach ($link_terkait as $item)
		<div class="d-md-flex justify-content-center">
                    <a href="{{$item->url}}" target="_blank" rel="noopener noreferrer" class="d-flex text-decoration-none justify-content-center">
                        <img src="{{ asset("storage/$item->media")}}" class="img-fluid" style="object-fit: cover;object-position:50% 50%">
                    </a>
		</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
