@extends('layouts.main')
@section('content')
<div class="container">
    <div class="text-center">
        <h2 class="mt-2"><b>Form Permohonan Keberatan</b></h2>
        <span class="border-top border-primary border-3 mb-4 px-4">&nbsp;</span>
    </div>
    
<!-- Button -->
<button
    type="button"
    class="btn btn-primary my-3"
    data-bs-toggle="modal"
    data-bs-target="#exampleModal">
    Ajukan Keberatan
</button>



<!-- Data Table -->
<div class="table-responsive my-2" style="font-size: 14px; max-height: 400px; overflow-y: auto;">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 60px;">#</th>
                <th scope="col">Detail</th>
                <th scope="col">Alasan Keberatan</th>
                <th scope="col">Nama Kuasa</th>
                <th scope="col">Deskripsi Keberatan</th>
                <th scope="col">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($data as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ route('form.keberatan.detail', ['id' => $item->kode_ajuan]) }}" class="text-primary">Lihat Detail Keberatan</a>
                    </td>
                    <td>{{ $item->alasan_keberatan }}</td>
                    <td>{{ $item->nama_pemohon }}</td>
                    <td>{{ $item->rincian_keberatan }}</td>
                    @php
                    $status = match ($item->status) {
                        'Dikirim' => '<span class="badge bg-warning text-dark">Keberatan Dikirim</span>',
                        'Diproses' => '<span class="badge bg-primary">Diproses PPID Pelaksana</span>',
                        'Ditolak' => '<span class="badge bg-danger">Ditolak PPID Pelaksana</span>',
                        'Selesai' => '<span class="badge bg-success">Keberatan Selesai</span>',
                        default => '<span class="badge bg-secondary">Tidak Diketahui</span>',
                    };
                    @endphp
                    <td>{!! $status !!}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data yang tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2">
        @foreach (request()->except(['page', 'per_page']) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <label for="per-page" class="text-muted mb-0">Items per page:</label>
        <select id="per-page" name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
            @foreach ([5, 10, 15, 30] as $option)
                <option value="{{ $option }}" @selected((int) request('per_page', 10) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    </form>

    <span class="text-muted">
        Page {{ $data->currentPage() }} of {{ $data->lastPage() }} ({{ $data->total() }} items)
    </span>

    <nav aria-label="Page navigation">
        {{ $data->onEachSide(2)->withQueryString()->links('pagination::bootstrap-5') }}
    </nav>
</div>

</div>
<!-- Modal -->
<div
    class="modal fade "
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    Form Permohonan Keberatan
                </h1>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <!-- Form -->
            <form
                id="reg"
                method="POST"
                action="{{ route('form.keberatan.store') }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="modal-body w-100">
                    <div class="mb-3">
                        <label
                            for="tanggal"
                            class="form-label">
                            Tanggal Ajuan (opsional)
                        </label>

                        <input
                            type="date"
                            class="form-control @error('tanggal') is-invalid @enderror"
                            name="tanggal"
                            id="tanggal"
                            value="{{ old('tanggal') }}"
                            autocomplete="off"
                            lang="id-ID">
                        @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Alasan Keberatan -->
                    <div class="mb-3">
                        <label
                            for="alasan_keberatan"
                            class="form-label">
                            Alasan Keberatan
                            <span class="text-danger">*</span>
                        </label>

                        <select class="form-select" name="alasan_keberatan" id="alasan_keberatan" required>
                            <option value="" selected disabled>-- Pilih alasan --</option>
                            <option value="Biaya yang dikenakan tidak wajar">Biaya yang dikenakan tidak wajar</option>
                            <option value="Data yang diberikan tidak valid">Data yang diberikan tidak valid</option>
                            <option value="Permintaan informasi ditanggapi tidak sebagaimana diminta">
                                Permintaan informasi ditanggapi tidak sebagaimana diminta
                            </option>
                            <option value="Informasi tidak ditanggapi">Informasi tidak ditanggapi</option>
                            <option value="Permohonan informasi ditolak">Permohonan informasi ditolak</option>
                        </select>
                        @error('alasan_keberatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Nama Pemohon -->
                    <div class="mb-3">
                        <label
                            for="nama_pemohon"
                            class="form-label">
                            Nama Pemohon/Instansi
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control @error('nama_pemohon') is-invalid @enderror"
                            name="nama_pemohon"
                            id="nama_pemohon"
                            required>
                        @error('nama_pemohon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Alamat Pemohon -->
                    <div class="mb-3">
                        <label
                            for="alamat"
                            class="form-label">
                            Alamat Pemohon/Instansi
                        </label>

                        <textarea
                            class="form-control @error('alamat') is-invalid @enderror"
                            id="alamat"
                            name="alamat"
                            rows="3"
                            ></textarea>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- No HP Pemohon -->
                    <div class="mb-3">
                        <label
                            for="hp_pemohon"
                            class="form-label">
                            No HP Pemohon
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="tel"
                            class="form-control @error('hp_pemohon') is-invalid @enderror"
                            name="hp_pemohon"
                            id="hp_pemohon"
                            inputmode="numeric"
                            required>
                        @error('hp_pemohon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Rincian Keberatan -->
                    <div class="mb-3">
                        <label
                            for="rincian_keberatan"
                            class="form-label">
                            Rincian Keberatan
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            class="form-control @error('rincian_keberatan') is-invalid @enderror"
                            id="rincian_keberatan"
                            name="rincian_keberatan"
                            rows="3"
                            required></textarea>
                        @error('rincian_keberatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Upload Identitas -->
                    <div class="mb-3">
                        <label
                            for="file_identitas"
                            class="form-label">
                            Upload Identitas / Surat
                            <span class="text-muted">
                                (KTP, Kartu Mahasiswa, Kartu Lembaga atau Surat)
                            </span>
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="file"
                            class="form-control @error('file_identitas') is-invalid @enderror"
                            name="file_identitas"
                            id="file_identitas"
                            accept="image/*"
                            required>
                        @error('file_identitas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Captcha -->
                    <div class="row mb-3">
                        <label for="g-recaptcha" class=""></label>
                        <div class="col-md-6">
                            <div name="g-recaptcha-response">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif                                
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        onclick="resetForm()">
                        Kosongkan
                    </button>

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>

                    <button
                        type="submit"
                        id="kt_sign_in_submit"
                        class="btn btn-primary">

                        <span class="indicator-label">
                            Kirim
                        </span>

                        <span
                            class="indicator-progress d-none">
                            Proses...
                            <span
                                class="spinner-border spinner-border-sm align-middle ms-2"
                                role="status"
                                aria-hidden="true">
                            </span>
                        </span>

                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection