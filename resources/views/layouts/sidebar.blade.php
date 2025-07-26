<div class="bg-light col-lg-4 shadow-sm py-2">
    <!-- Trending Tabs (Sidebar Content) -->
    <div class="bg-light p-3 rounded">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="trendingTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="latest-tab" data-bs-toggle="tab" href="#latest" role="tab">Berita Terkini</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="trending-tab" data-bs-toggle="tab" href="#trending" role="tab">Berita Trending</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3">
            <!-- Trending Tab -->
            <div class="tab-pane fade" id="trending" role="tabpanel">
                @foreach ($trending as $item)
                <a href="{{ route('post.view', ['post' => $item->id]) }}" target="_blank" rel="noopener noreferrer">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('storage/'.$item->media1) }}" class="me-3 rounded" style="width: 70px; height: 70px;" alt="Trending Image">
                        <div>
                            <a href="{{ route('post.view', ['post' => $item->id]) }}" class="fw-bold text-dark">{{ $item->judul }}</a>
                            <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</p>
                            <p class="text-muted small mb-0">{{ $item->pengunjung }}x dilihat</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Latest Tab -->
            <div class="tab-pane fade show active" id="latest" role="tabpanel">
                @foreach ($latest as $item)
                <a href="{{ route('post.view', ['post' => $item->id]) }}" target="_blank" rel="noopener noreferrer">
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

        <!-- Kategori Berita -->
        <div class="mt-4">
            <div class="bg-primary text-white text-center py-2 fw-bold position-relative rounded-top">
                KATEGORI BERITA
                <div class="position-absolute top-100 start-50 translate-middle mt-0" style="width: 0; height: 0; border-left: 8px solid transparent; border-right: 8px solid transparent; border-top: 8px solid #0d6EFD;"></div>
            </div>
            <ul class="list-unstyled bg-light p-2 rounded-bottom mb-0">
                @foreach ($kategoriBerita as $kategori)
                <a href="{{route('post.category', $kategori->id)}}" class="text-decoration-none text-dark">
                <li class="d-flex justify-content-between align-items-center py-1">
                    <span><i class="bi bi-chevron-right small"></i> {{ $kategori->kategori }}</span>
                    <span class="badge rounded-pill kategori-badge bg-primary">{{ $kategori->post->count() }}</span>
                </li>
                </a>
                @endforeach
            </ul>
        </div>
    </div>

    <style>
        .kategori-badge {
            color: #fff;
            transition: background-color 0.3s ease;
        }

        li:hover .kategori-badge {
            background-color: #f4ff54 !important;
            color : #333;
        }
    </style>



    @if(\Schema::hasTable('page_embed_category') && \Schema::hasTable('page_embed'))
        <!-- Dynamic Tabs -->
        <ul class="nav nav-tabs" id="embedTab" role="tablist">
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
                                <div class="d-flex mb-3">
                                    <a href="{{ url('/page?id=' . ($halaman->id ?? 0)) }}" target="_blank" >
                                    <img src="{{Str::startsWith($embed->currentpage->media, 'images/') ? asset('storage/' . $embed->currentpage->media)
                                                :(Str::startsWith($embed->currentpage->tambahan1, 'images/') ? asset('storage/' . $embed->currentpage->tambahan1)
                                                :(Str::startsWith($embed->currentpage->tambahan2, 'images/') ? asset('storage/' . $embed->currentpage->tambahan2)
                                                : asset('storage/' . $embed->currentpage->tambahan3) )) }}"
                                        class="me-3 rounded"
                                        style="width: 70px; height: 70px;"
                                        alt="Thumb">
                                    </a>
                                    <div>
                                        <a href="{{ url('/page?id=' . ($halaman->id ?? 0)) }}" target="_blank" class="fw-bold text-dark">
                                            {{ $embed->currentpage->sub_sub_sub_sub_menu
                                                ?? $embed->currentpage->sub_sub_sub_menu
                                                ?? $embed->currentpage->sub_sub_menu
                                                ?? $embed->currentpage->sub_menu
                                                ?? 'Tanpa Judul' }}
                                        {{-- <p class="text-muted small mb-0">
                                            {{ \Carbon\Carbon::parse($halaman->created_at)->format('F d, Y') }}
                                        </p> --}}
                                        </a>
                                    </div>
                                </div>
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
    @if(\Route::current()->getName() !== 'page.show' 
    && \Route::current()->getName() !== 'post.view' 
    && \Route::current()->getName() !== 'post.list'
    && \Route::current()->getName() !== 'post.category'
    && \Route::current()->getName() !== 'post.search')
        <h5 class="fw-bold pt-4">Link Terkait</h5>
        <hr>
        <div class="tab-content mt-3">
            <!-- Link Terkait Tab Content -->
            <div class="tab-pane fade show active" id="link" role="tabpanel">
                <div class="row mb-3 align-items-center justify-content-center">
                    @foreach ($link_terkait as $item)
                    <div class="row justify-content-center">
                        <a href="{{$item->url}}" target="_blank" rel="noopener noreferrer" class="d-flex text-decoration-none justify-content-center">
                            <span class="w-50 d-flex text-decoration-none justify-content-center"><img src="{{ asset("/storage/$item->media") }}" class="img-fluid" style="object-fit: cover;object-position:50% 50%" width="250px" height="250px"></span>
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
    @endif
    @if (\Storage::exists('jadwal-pelayanan.jpeg'))
    <h5 class="fw-bold pt-4">Jadwal Pelayanan</h5>
    <hr class="mb-2">
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" role="tabpanel">
            <div class="d-flex flex-wrap justify-content-evenly">
                @php
                    $imagePath = 'jadwal-pelayanan.jpeg';
                    $judul = \Storage::get('jadwal-pelayanan.txt');
                    $version = \Storage::lastModified($imagePath);
                @endphp

                <div class="w-75 img-hover-container p-2"
                     data-bs-toggle="modal"
                     data-bs-target="#mediaModal"
                     data-bs-image="{{ asset('storage/' . $imagePath) . '?v=' . $version }}">
                    
                    <img class="img-fluid h-auto"
                         src="{{ asset('storage/' . $imagePath) . '?v=' . $version }}"
                         alt="Image">

                    <div class="img-hover-overlay">
                        <h5 class="m-0 fst-italic">{{ $judul }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>   
@endif

</div>
