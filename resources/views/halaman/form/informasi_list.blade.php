@extends('layouts.dashboard')
@section('content')
@php
    $statusOrder = $statuses ?? ['Dikirim', 'Diproses', 'Selesai', 'Ditolak'];
    $groupedItems = $data ?? [];

    $statusClasses = [
        'Dikirim' => ['dot' => 'bg-secondary', 'badge' => 'text-bg-light text-secondary', 'pill' => 'bg-secondary-subtle text-secondary-emphasis', 'label' => 'Menunggu Konfirmasi'],
        'Diproses' => ['dot' => 'bg-primary', 'badge' => 'bg-primary-subtle text-primary-emphasis', 'pill' => 'bg-primary-subtle text-primary-emphasis', 'label' => 'Diproses PPID Pelaksana'],
        'Selesai' => ['dot' => 'bg-success', 'badge' => 'bg-success-subtle text-success-emphasis', 'pill' => 'bg-success-subtle text-success-emphasis', 'label' => 'Permohonan Informasi Selesai'],
        'Ditolak' => ['dot' => 'bg-danger', 'badge' => 'bg-danger-subtle text-danger-emphasis', 'pill' => 'bg-danger-subtle text-danger-emphasis', 'label'=> 'Ditolak PPID Pelaksana'],
    ];
@endphp

<div class="card border-0 shadow-sm bg-light-subtle">
    <div class="card-body p-4 p-md-4">
        <div class="d-flex align-items-center justify-content-between pb-3 border-bottom mb-4">
            <div>
                <p class="mb-1 text-uppercase small fw-bold text-secondary" style="letter-spacing: 0.18em;">Informasi</p>
                <h3 class="mb-0 h4 fw-bold text-dark">Daftar Data Permohonan</h3>
            </div>
        </div>

        @forelse ($statusOrder as $status)
            @php
                $statusItems = $groupedItems[$status] ?? null;
                $statusDot = $statusClasses[$status]['dot'] ?? 'bg-secondary';
                $statusBadge = $statusClasses[$status]['badge'] ?? 'text-bg-light text-secondary';
            @endphp

            @if ($statusItems && $statusItems->isNotEmpty())
                <details class="mb-4">
                    <summary class="d-flex align-items-center gap-2 px-2 mb-3" style="cursor: pointer; list-style: none;">
                        <span class="d-inline-block rounded-circle {{ $statusDot }}" style="width: 10px; height: 10px;"></span>
                        <h4 class="mb-0 fs-6 fw-semibold text-dark status-label-hover">
                            <span>{{ $statusClasses[$status]['label'] }}</span>
                        </h4>
                        <span class="badge rounded-pill text-bg-light text-secondary">
                            {{ $statusItems->total() }}
                        </span>
                        <span class="ms-auto text-secondary small" aria-hidden="true">⌄</span>
                    </summary>

                    <div class="list-group overflow-hidden border rounded-3 shadow-sm">
                        <div class="list-group-item bg-light d-none d-md-flex align-items-center fw-semibold text-uppercase text-secondary small px-3 py-2" style="letter-spacing: 0.12em;">
                            <div class="row w-100 g-0 align-items-center small">
                                <div class="col-md-2">Kode Permohonan</div>
                                <div class="col-md-3">Rincian</div>
                                <div class="col-md-3">Status</div>
                                <div class="col-md-2">Tanggal Permohonan</div>
                                <div class="col-md-2 text-end">Identitas</div>
                            </div>
                        </div>

                        @foreach ($statusItems as $item)
                            @php
                                $itemStatus = data_get($item, 'status', 'Dikirim');
                                $itemBadge = $statusClasses[$itemStatus]['pill'] ?? 'bg-secondary-subtle text-secondary-emphasis';
                                $itemName = data_get($item, 'kode_permohonan') ?: data_get($item, 'nama') ?: 'Nama Pemohon';
                                $itemLabel = data_get($item, 'kategori_pemohon') ?: data_get($item, 'label') ?: 'Informasi';
                                $itemTitle = route('form.informasi.detail',['id'=>$item->kode_permohonan]);
                                $itemUpdated = data_get($item, 'updated_at') ?: data_get($item, 'created_at') ?: data_get($item, 'updated') ?: 'Baru';
                                $itemId = data_get($item, 'id') ?? data_get($item, 'permohonan_id') ?? data_get($item, 'uuid');
                                $itemUpdateUrl = route('permohonan.informasi.update',['id'=>$item->id]);
                                $itemImage = data_get($item, 'identitas') ?: data_get($item, 'foto') ?: data_get($item, 'image');
                                $itemImageUrl = null;
                                if ($itemImage) {
                                    $itemImagePath = str_replace('\\', '/', trim($itemImage));
                                    if (filter_var($itemImagePath, FILTER_VALIDATE_URL)) {
                                        $itemImageUrl = $itemImagePath;
                                    } else {
                                        $itemImagePath = ltrim($itemImagePath, '/');
                                        $itemImagePath = preg_replace('#^(public/|storage/)#i', '', $itemImagePath);
                                        $itemImageUrl = asset('storage/' . $itemImagePath);
                                    }
                                }

                                if ($itemUpdated instanceof \Carbon\Carbon || $itemUpdated instanceof \DateTime) {
                                    $itemUpdated = $itemUpdated->translatedFormat('d M Y');
                                }
                            @endphp

                            <div class="list-group-item px-3 py-3 hover-bg-light transition">
                                <div class="row g-3 align-items-center">
                                    <div class="col-12 col-md-2">
                                        <p class="mb-0 mt-2 text-dark fw-semibold text-truncate">{{ Str::limit($itemName, 100) }}</p>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <span class="badge text-bg-light text-secondary fw-semibold text-uppercase small rounded-pill">
                                            {{ $itemLabel }}
                                        </span>
                                        <p><a href="{{$itemTitle}}" class="mb-0 mt-2 text-dark fw-semibold text-truncate">Lihat detail permohonan</a></p>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <select
                                            class="form-select form-select-sm status-select rounded-pill fw-semibold {{ $itemBadge }}"
                                            data-id="{{ $itemId }}"
                                            data-update-url="{{ $itemUpdateUrl }}"
                                            data-current-status="{{ $itemStatus }}"
                                            aria-label="Ubah status"
                                        >
                                            @foreach ($statusOrder as $optionStatus)
                                                <option value="{{ $optionStatus }}" @selected($itemStatus === $optionStatus)>{{ $statusClasses[$optionStatus]['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2 text-secondary small">
                                        {{ $itemUpdated }}
                                    </div>
                                    <div class="col-12 col-md-2 text-md-end text-secondary small">
                                        <div class="row">
                                            <div class="col-sm-6 d-flex align-items-center justify-content-end">
                                                @if ($itemImageUrl)
                                                    <a href="{{ $itemImageUrl }}" target="_blank" rel="noopener" class="mb-0 mt-2">
                                                        <img src="{{ $itemImageUrl }}" alt="Foto identitas" class="rounded" style="width: 42px; height: 42px; object-fit: cover;">
                                                    </a>
                                                @else
                                                    <i class="bi bi-image text-secondary" aria-label="Tidak ada gambar"></i>
                                                @endif
                                            </div>
                                            <div class="col-sm-6"><span class="badge text-bg-light text-secondary fw-semibold text-uppercase small rounded-pill">
                                            {{ $item->jenis_permohonan ?? $item->jenis_identitas}}
                                        </span>
                                        <p>{{$item->nomor_identitas}}</p></div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (method_exists($statusItems, 'links'))
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3 mb-3">
                            <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2">
                                @foreach (request()->except(['page', 'per_page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <label for="per-page-{{ Str::slug($status) }}" class="text-muted mb-0">Items per page:</label>
                                <select id="per-page-{{ Str::slug($status) }}" name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    @foreach ([5, 10, 15, 30] as $option)
                                        <option value="{{ $option }}" @selected((int) request('per_page', 10) === $option)>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </form>

                            <span class="text-muted">
                                Page {{ $statusItems->currentPage() }} of {{ $statusItems->lastPage() }} ({{ $statusItems->total() }} items)
                            </span>

                            <nav aria-label="Page navigation">
                                {{ $statusItems->onEachSide(2)->withQueryString()->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    @endif
                </details>
            @endif
        @empty
        @endforelse
    </div>
</div>

<style>
    .status-label-hover span {
        position: relative;
    }

    .status-label-hover span::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -3px;
        height: 2px;
        background-color: currentColor;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .2s ease;
    }

    summary:hover .status-label-hover span::after,
    summary:focus-visible .status-label-hover span::after {
        transform: scaleX(1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusClasses = @json($statusClasses);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        function applyStatusClass(select, status) {
            const classes = statusClasses[status]?.pill || 'bg-secondary-subtle text-secondary-emphasis';
            select.classList.remove(
                'bg-secondary-subtle', 'text-secondary-emphasis',
                'bg-primary-subtle', 'text-primary-emphasis',
                'bg-success-subtle', 'text-success-emphasis',
                'bg-danger-subtle', 'text-danger-emphasis',
                'bg-warning-subtle', 'text-warning-emphasis',
                'text-bg-light', 'text-secondary'
            );
            select.classList.add(...classes.split(' '));
        }

        document.querySelectorAll('.status-select').forEach(function (select) {
            applyStatusClass(select, select.value);

            select.addEventListener('change', function () {
                const selectedStatus = this.value;
                const url = this.dataset.updateUrl;

                if (!url) {
                    this.value = this.dataset.currentStatus;
                    applyStatusClass(this, this.dataset.currentStatus);
                    if (window.toastr) {
                        window.toastr.warning('URL update status tidak tersedia');
                    }
                    return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="status" value="${selectedStatus}">
                `;
                document.body.appendChild(form);
                form.submit();
            });
        });
    });
</script>
@endsection