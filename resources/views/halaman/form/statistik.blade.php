{{-- statistik form --}}
@extends('layouts.main')
@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="mb-1">Statistik</h3>
            <p class="text-muted mb-0">Ringkasan data informasi, keberatan, dan survei tahun {{ $year ?? now()->year }}</p>
        </div>

        @php
            $currentYear = now()->year;
            $selectedYear = (int) ($year ?? $currentYear);
            $minYear = $currentYear - 3;
        @endphp

        <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center gap-2">
            <label for="year" class="form-label mb-0 fw-semibold">Tahun</label>
            <select id="year" name="year" class="form-select" style="max-width: 140px;" onchange="this.form.submit()">
                @for ($i = $currentYear; $i >= $minYear; $i--)
                    <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </form>
    </div>

    @php
        $informasi = $statistik['informasi'] ?? [];
        $keberatan = $statistik['keberatan'] ?? [];
        $survey = $statistik['survey'] ?? [];
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="card-body bg-primary text-white py-3 px-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                        <div>
                            <div class="small text-white-50 text-uppercase fw-semibold">Ringkasan</div>
                            <h4 class="mb-0">Statistik Umum</h4>
                        </div>
                        <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">{{ $selectedYear }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-lg-6">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body bg-primary text-white d-flex flex-column rounded-4">
                            <div class="display-6 fw-bold mt-2">{{ $informasi['total'] ?? 0 }}</div>
                            <div class="small mt-auto">Jumlah Permohonan</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body bg-warning text-white rounded-4">
                            <div class="display-6 fw-bold mt-2">{{ $informasi['diproses'] ?? 0 }}</div>
                            <div class="small mt-auto">Permohonan Diproses</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body bg-success text-white d-flex flex-column rounded-4">
                            <div class="display-6 fw-bold mt-2">{{ $informasi['selesai'] ?? 0 }}</div>
                            <div class="small mt-auto">Permohonan Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body bg-danger text-white d-flex flex-column rounded-4">
                            <div class="display-6 fw-bold mt-2">{{ $informasi['ditolak'] ?? 0 }}</div>
                            <div class="small mt-auto">Permohonan Ditolak</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body bg-secondary text-white d-flex flex-column rounded-4">
                            <div class="display-6 fw-bold mt-2 ">{{ $keberatan['total'] ?? 0 }}</div>
                            <div class="small mt-auto">Jumlah Keberatan</div>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body bg-danger-subtle d-flex flex-column rounded-4">
                            <div class="display-6 fw-bold mt-2 text-danger">{{ $keberatan['ditolak'] ?? 0 }}</div>
                            <div class="small mt-auto">Keberatan Ditolak</div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="col-12">
            <div class="card bg-secondary-subtle border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="text-muted small">Survey Total</div>
                    <div class="display-6 fw-bold mt-2">{{ $survey['total'] ?? 0 }}</div>

                    <div class="row g-3 mt-2">
                        @php
                            $surveyAverages = [
                                ['key' => 'avg_pelayanan', 'label' => 'Pelayanan Petugas PPID'],
                                ['key' => 'avg_kecepatan_pelayanan', 'label' => 'Kecepatan Tindak Lanjut Permohonan'],
                                ['key' => 'avg_kesesuaian_informasi', 'label' => 'Kesesuaian Informasi'],
                                ['key' => 'avg_kualitas_pelayanan', 'label' => 'Kualitas Pelayanan PPID'],
                            ];

                            $surveyRatingLabels = [
                                ['min' => 4.5, 'label' => 'Sangat Baik'],
                                ['min' => 3.5, 'label' => 'Baik'],
                                ['min' => 2.5, 'label' => 'Cukup Baik'],
                                ['min' => 1.5, 'label' => 'Buruk'],
                                ['min' => 0, 'label' => 'Sangat Buruk'],
                            ];

                            $formatSurveyRating = function ($value) use ($surveyRatingLabels) {
                                $avgValue = (float) $value;
                                if(!empty($avgValue)){
                                    foreach ($surveyRatingLabels as $rating) {
                                        if ($avgValue >= $rating['min']) {
                                            return $rating['label'];
                                        }
                                    }
                                }else{
                                    return 'Tidak Diketahui';
                                }
                            };
                        @endphp

                        @foreach($surveyAverages as $average)
                            @php
                                $avgValue = $survey[$average['key']] ?? 0;
                                $avgLabel = $formatSurveyRating($avgValue);
                            @endphp
                            <div class="col-md-3 col-sm-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex flex-column">
                                        <div class="text-muted small">{{ $average['label'] }}</div>
                                        <div class="display-8 fw-bold mt-auto">{{ $avgLabel }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Permohonan Informasi</h5>
                    <a href="{{ route('form.informasi') }}" class="small text-primary text-decoration-none">Lihat semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(collect($inf ?? [])->take(3) as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td title="{{ $item->rincian_kebutuhan ?? '-' }}">
                                            {{ \Illuminate\Support\Str::limit($item->rincian_kebutuhan ?? '-', 30, '...') }}
                                        </td>
                                        <td>
                                            @php
                                                $status = $item->status ?? '';
                                            @endphp
                                            @if($status == 'Selesai')
                                                <span class="badge bg-success">{{ $status }}</span>
                                            @elseif($status == 'Diproses')
                                                <span class="badge bg-warning text-dark">{{ $status }}</span>
                                            @elseif($status == 'Ditolak')
                                                <span class="badge bg-danger">{{ $status }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $status ?: 'Belum ada' }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Tidak ada data informasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Ajuan Keberatan</h5>
                    <a href="{{ route('form.keberatan') }}" class="small text-primary text-decoration-none">Lihat semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(collect($keb ?? [])->take(3) as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_pemohon ?? '-' }}</td>
                                        <td>
                                            @php
                                                $status = $item->status ?? '';
                                            @endphp
                                            @if($status == 'Ditolak')
                                                <span class="badge bg-danger">{{ $status }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $status ?: 'Belum ada' }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Tidak ada data keberatan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Survey Per Bulan</h5>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="downloadSurveyChartJpg">
                            Download JPG
                        </button>
                        <span class="badge bg-light text-dark">{{ $survey['total'] ?? 0 }} total</span>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $surveyPerBulan = $survey['per_bulan'] ?? [];

                        $surveyLabels = collect($surveyPerBulan)->pluck('month')->all();
                        $surveyData = collect($surveyPerBulan)->pluck('count')->all();
                    @endphp

                    @if(!empty($surveyPerBulan))
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <div style="height: 320px;">
                            <canvas id="surveyChart"></canvas>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                if (typeof Chart === 'undefined') {
                                    console.warn('Chart.js is not loaded.');
                                    return;
                                }

                                const labels = @json($surveyLabels);
                                const values = @json($surveyData);

                                const surveyChart = new Chart(document.getElementById('surveyChart'), {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Jumlah Survey',
                                            data: values,
                                            backgroundColor: 'rgba(13, 110, 253, 0.7)',
                                            borderColor: 'rgba(13, 110, 253, 1)',
                                            borderWidth: 1,
                                            borderRadius: 8,
                                            maxBarThickness: 42
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                display: false
                                            }
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                ticks: {
                                                    precision: 0
                                                },
                                                grid: {
                                                    color: 'rgba(0,0,0,0.06)'
                                                }
                                            },
                                            x: {
                                                grid: {
                                                    display: false
                                                }
                                            }
                                        }
                                    }
                                });

                                document.getElementById('downloadSurveyChartJpg').addEventListener('click', function () {
                                    const canvas = surveyChart.canvas;
                                    const link = document.createElement('a');
                                    link.download = 'survey-per-bulan.jpg';
                                    link.href = canvas.toDataURL('image/jpeg', 0.9);
                                    link.click();
                                });
                            });
                        </script>
                    @else
                        <div class="text-center text-muted py-4">Tidak ada data survey.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection