<div class="col-lg-4 shadow-sm py-2">
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
                        <p class="text-muted small mb-0">{{$item->pengunjung}}x dilihat</p>
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
    @if(\Schema::hasTable('page_embed_category') && \Schema::hasTable('page_embed'))
        <!-- Dynamic Tabs -->
        <ul class="mt-5 nav nav-tabs" id="embedTab" role="tablist">
            @foreach ($embeds as $index => $cat)
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($index === 0) active @endif"
                    id="tab-{{ $cat->id }}"
                    data-bs-toggle="tab"
                    href="#tabcontent-{{ $cat->id }}"
                    role="tab"
                    aria-controls="tabcontent-{{ $cat->id }}"
                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                    >
                        {{ $cat->kategori }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content mt-3">
            @foreach ($embeds as $index => $cat)
                <div class="tab-pane fade @if ($index === 0) show active @endif"
                    id="tabcontent-{{ $cat->id }}"
                    role="tabpanel"
                    aria-labelledby="tab-{{ $cat->id }}">

                    @if (isset($cat->paginated_valid_embeds) && $cat->paginated_valid_embeds->count())
                        @foreach ($cat->paginated_valid_embeds as $embed)
                            @php $halaman = $embed->halaman; @endphp
                            <a href="{{ url('/page?id=' . ($halaman->id ?? 0)) }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                <div class="d-flex mb-3">
                                    <img src="{{ asset('storage/' . ($embed->currentpage->media ?? 'default.jpg')) }}"
                                        class="me-3 rounded"
                                        style="width: 70px; height: 70px;"
                                        alt="Thumb">
                                    <div>
                                        <span class="fw-bold text-dark">
                                            {{ $embed->currentpage->sub_sub_sub_sub_menu
                                                ?? $embed->currentpage->sub_sub_sub_menu
                                                ?? $embed->currentpage->sub_sub_menu
                                                ?? $embed->currentpage->sub_menu
                                                ?? 'Tanpa Judul' }}
                                        </span>
                                        <p class="text-muted small mb-0">
                                            {{ \Carbon\Carbon::parse($halaman->created_at)->format('F d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center">
                            {{ $cat->paginated_valid_embeds->appends(request()->except("page_{$cat->id}"))->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <p class="text-muted">Belum ada halaman di kategori ini.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
    <h5 class="fw-bold pt-4">Link Terkait</h5>
    <hr>
    <div class="tab-content mt-3">
        <!-- Link Terkait Tab Content -->
        <div class="tab-pane fade show active" id="link" role="tabpanel">
            <div class="row mb-3 align-items-center justify-content-center">
                @foreach ($link_terkait as $item)
                <div class="row justify-content-center">
                    <a href="{{$item->url}}" target="_blank" rel="noopener noreferrer" class="d-flex text-decoration-none justify-content-center">
                        <img src="{{ asset("storage/$item->media")}}" class="w-50 my-3 img-fluid" style="object-fit: cover;object-position:50% 50%">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <h5 class="fw-bold pt-4">Government Public Relation</h5>
    <hr class="mb-2">
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="gpr" role="tabpanel">
            <div class="mb-3 align-items-center justify-content-center">
                <script type="text/javascript" src="js/gpr.min.js" async></script>
                <div class="rounded" style="background-color:#23277B;border: 6px solid #23277B!important">
                    <div id="gpr-kominfo-widget-body"></div>
                </div> 
            </div>
        </div>
    </div>
</div>
