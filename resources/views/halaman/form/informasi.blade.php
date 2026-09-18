@extends('layouts.main')
@section('content')
<div class="container">
     <div class="text-center">
        <h2 class="mt-2"><b>Form Permohonan Informasi</b></h2>
        <span class="border-top border-primary border-3 mb-4 px-4">&nbsp;</span>
    </div>
    <div class="d-flex justify-content-between">
        <!-- Button -->
    <button
        type="button"
        class="btn btn-primary my-3"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal">
        Ajukan Permohonan
    </button>
     {{-- searchbar --}}
    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2">
        <input type="text" name="q" class="form-control form-control-sm @error('q') is-invalid @enderror" placeholder="Cari Nama Pemohon..." value="{{ request('q') }}">
        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
        @error('q')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </form>
    </div>



<!-- Data Table -->
<div class="table-responsive my-2" style="font-size: 14px; max-height: 400px; overflow-y: auto;">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 60px;">#</th>
                <th scope="col">Detail</th>
                <th scope="col">Nama Pemohon</th>
                <th scope="col">Kategori Permohonan</th>
                <th scope="col">Rincian Kebutuhan</th>
                <th scope="col">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($data as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ route('form.informasi.detail', $item->kode_permohonan) }}" class="text-primary">Lihat Detail Permohonan</a>
                    </td>
                    <td>{{ $item->nama_pemohon }}</td>
                    <td>{{ $item->kategori_permohonan }}</td>
                    <td>{{ $item->rincian_kebutuhan }}</td>
                    @php
                    $status = match ($item->status) {
                        'Dikirim' => '<span class="badge bg-warning text-dark">Permohonan Informasi Dikirim</span>',
                        'Diproses' => '<span class="badge bg-primary">Diproses PPID Pelaksana</span>',
                        'Ditolak' => '<span class="badge bg-danger">Ditolak PPID Pelaksana</span>',
                        'Selesai' => '<span class="badge bg-success">Permohonan Informasi Selesai</span>',
                        
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
                    Form Permohonan Informasi
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
                action="{{ route('form.informasi.store') }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="modal-body w-100">

                    <!-- Kategori Permohonan -->
                    <div class="mb-3">
                        <label
                            for="kategori_permohonan"
                            class="form-label">
                            Kategori Permohonan
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('kategori_permohonan') is-invalid @enderror"
                            name="kategori_permohonan"
                            id="kategori_permohonan"
                            required>
                            <option class="" value="" selected disabled>
                                Pilih Kategori Permohonan
                            </option>
                            <option class="" value="Mahasiswa/Pelajar">Mahasiswa/Pelajar</option>
                            <option class="" value="Lembaga/Instansi">Lembaga/Instansi</option>
                            <option class="" value="Perorangan">Perorangan</option>
                        </select>
                        @error('kategori_permohonan')
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
                            Nama Pemohon / Instansi
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

                    <!-- Jenis Identitas -->
                    <div class="mb-3">
                        <label
                            for="jenis_identitas"
                            class="form-label">
                            Jenis Identitas
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('jenis_identitas') is-invalid @enderror"
                            name="jenis_identitas"
                            id="jenis_identitas"
                            required>
                            <option value="" selected disabled>
                                Pilih Jenis Identitas
                            </option>

                            <option value="KTP">KTP</option>
                            <option value="Nomor Badan Hukum">
                                Nomor Badan Hukum
                            </option>
                            <option value="Nomor Surat Mahasiswa">
                                Nomor Surat Mahasiswa
                            </option>
                            <option value="Instansi">
                                Instansi
                            </option>
                        </select>

                        @error('jenis_identitas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- No Identitas -->
                    <div class="mb-3">
                        <label
                            for="no_identitas"
                            class="form-label">
                            No Identitas
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control @error('no_identitas') is-invalid @enderror"
                            name="no_identitas"
                            id="no_identitas"
                            required>
                        @error('no_identitas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Alamat Pemohon -->
                    <div class="mb-3">
                        <label
                            for="alamat_pemohon"
                            class="form-label">
                            Alamat Pemohon/Instansi
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            class="form-control @error('alamat_pemohon') is-invalid @enderror"
                            id="alamat_pemohon"
                            name="alamat_pemohon"
                            rows="3"
                            required></textarea>
                        @error('alamat_pemohon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Pekerjaan Pemohon -->
                    <div class="mb-3">
                        <label
                            for="pekerjaan_pemohon"
                            class="form-label">
                            Pekerjaan Pemohon
                        </label>

                        <input
                            type="text"
                            class="form-control @error('pekerjaan_pemohon') is-invalid @enderror"
                            name="pekerjaan_pemohon"
                            id="pekerjaan_pemohon"
                            >
                        @error('pekerjaan_pemohon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- No HP Pemohon -->
                    <div class="mb-3">
                        <label
                            for="no_hp_pemohon"
                            class="form-label">
                            No HP Pemohon
                        </label>

                        <input
                            type="tel"
                            class="form-control @error('no_hp_pemohon') is-invalid @enderror"
                            name="no_hp_pemohon"
                            id="no_hp_pemohon"
                            inputmode="numeric"
                            >
                        @error('no_hp_pemohon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email Pemohon -->
                    <div class="mb-3">
                        <label
                            for="email_pemohon"
                            class="form-label">
                            Email Pemohon
                        </label>

                        <input
                            type="text"
                            class="form-control @error('email_pemohon') is-invalid @enderror"
                            id="email_pemohon"
                            name="email_pemohon"
                            placeholder="name@gmail.com">
                        @error('email_pemohon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Rincian Kebutuhan -->
                    <div class="mb-3">
                        <label
                            for="rincian_kebutuhan"
                            class="form-label">
                            Rincian Kebutuhan
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            class="form-control @error('rincian_kebutuhan') is-invalid @enderror"
                            id="rincian_kebutuhan"
                            name="rincian_kebutuhan"
                            rows="3"
                            required></textarea>
                        @error('rincian_kebutuhan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tujuan Informasi -->
                    <div class="mb-3">
                        <label
                            for="tujuan_informasi"
                            class="form-label">
                            Tujuan Informasi
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            class="form-control @error('tujuan_informasi') is-invalid @enderror"
                            id="tujuan_informasi"
                            name="tujuan_informasi"
                            rows="3"
                            required></textarea>
                        @error('tujuan_informasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Cara Memperoleh Informasi -->
                    <div class="mb-3">
                        <label
                            for="memperoleh_informasi"
                            class="form-label">
                            Cara Memperoleh Informasi
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('memperoleh_informasi') is-invalid @enderror"
                            name="memperoleh_informasi"
                            id="memperoleh_informasi"
                            required>
                            <option value="" selected disabled>
                                Pilih Cara Memperoleh Informasi
                            </option>

                            <!-- Populate sesuai data asli -->
                            <option value="Mendapat salinan hardcopy/softcopy">
                                Mendapat salinan hardcopy/softcopy
                            </option>
                            <option value="Melihat/Membaca/Mendegarakan/Mencatat">
                                Melihat/Membaca/Mendegarakan/Mencatat
                            </option>
                        </select>
                    </div>

                    <!-- Cara Mendapatkan Informasi -->
                    <div class="mb-3">
                        <label
                            for="mendapatkan_informasi"
                            class="form-label">
                            Cara Mendapatkan Informasi
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('mendapatkan_informasi') is-invalid @enderror"
                            name="mendapatkan_informasi"
                            id="mendapatkan_informasi"
                            required>
                            <option value="" selected disabled>
                                Pilih Cara Mendapatkan Informasi
                            </option>

                            <!-- Populate sesuai data asli -->
                            <option value="WhatsApp">
                                WhatsApp
                            </option>
                            <option value="Email">
                                Email
                            </option>
                            <option value="Fotocopy">
                                Fotocopy
                            </option>
                            <option value="Jasa Expedisi">
                                Jasa Expedisi
                            </option>
                            <option value="Mengambil Langsung">
                                Mengambil Langsung
                            </option>
                        </select>
                    </div>

                    <!-- Upload Identitas -->
                    <div class="mb-3">
                        <label
                            for="file_identitas"
                            class="form-label">
                            Upload Identitas/Surat Permohonan Informasi
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