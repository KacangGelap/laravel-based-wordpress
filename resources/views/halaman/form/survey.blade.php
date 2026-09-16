@extends('layouts.main')
@section('content')
<div class="container my-4">
<form
    id="survey-form"
    method="POST"
    action="{{ route('form.survey.store') }}"
>
    @csrf

    {{-- ========================================================= --}}
    {{-- STEP 1 --}}
    {{-- ========================================================= --}}

    <div id="step-1" class="form-step">

        <h4 class="mb-0">
            Data Diri Pengisi Survey
        </h4>

        <hr>

        {{-- Nama --}}
        <div class="row mb-4">
            <label
                for="nama"
                class="col-md-4 col-form-label fw-semibold"
            >
                Nama Lengkap
                <span class="text-danger">*</span>
            </label>

            <div class="col-md-8">
                <input
                    type="text"
                    class="form-control"
                    id="nama"
                    name="nama"
                    placeholder="Masukkan Nama Lengkap"
                    autocomplete="off"
                    required
                >
            </div>
        </div>


        {{-- Jenis Kelamin --}}
        <div class="row mb-4">
            <label class="col-md-4 col-form-label fw-semibold">
                Jenis Kelamin
                <span class="text-danger">*</span>
            </label>

            <div class="col-md-8">

                <div class="btn-group w-100">

                    <input
                        type="radio"
                        class="btn-check"
                        name="jenis_kelamin"
                        id="laki-laki"
                        value="Laki-laki"
                        required
                    >

                    <label
                        class="btn btn-outline-primary"
                        for="laki-laki"
                    >
                        Laki-laki
                    </label>


                    <input
                        type="radio"
                        class="btn-check"
                        name="jenis_kelamin"
                        id="perempuan"
                        value="Perempuan"
                    >

                    <label
                        class="btn btn-outline-primary"
                        for="perempuan"
                    >
                        Perempuan
                    </label>

                </div>

            </div>
        </div>


        {{-- Usia --}}
        <div class="row mb-4">
            <label
                for="usia"
                class="col-md-4 col-form-label fw-semibold"
            >
                Kategori Usia
                <span class="text-danger">*</span>
            </label>

            <div class="col-md-8">

                <select
                    class="form-select"
                    id="usia"
                    name="usia"
                    required
                >
                    <option value="" selected disabled>
                        Pilih Kategori Usia
                    </option>

                    <option value="> 30 Tahun">
                        &gt; 30 Tahun
                    </option>

                    <option value="25 - 30 Tahun">
                        25 - 30 Tahun
                    </option>

                    <option value="18 - 25 Tahun">
                        18 - 25 Tahun
                    </option>

                    <option value="< 18 Tahun">
                        &lt; 18 Tahun
                    </option>

                </select>

            </div>
        </div>


        {{-- Email --}}
        <div class="row mb-4">
            <label
                for="email"
                class="col-md-4 col-form-label fw-semibold"
            >
                Email
                <span class="text-danger">*</span>
            </label>

            <div class="col-md-8">

                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Masukkan Email"
                    autocomplete="email"
                    required
                >

            </div>
        </div>


        {{-- Kategori Responden --}}
        <div class="row mb-4">
            <label
                for="kategori_responden"
                class="col-md-4 col-form-label fw-semibold"
            >
                Kategori Responden
                <span class="text-danger">*</span>
            </label>

            <div class="col-md-8">

                <select
                    class="form-select"
                    id="kategori_responden"
                    name="kategori_responden"
                    required
                >
                    <option value="" selected disabled>
                        Pilih Kategori Responden
                    </option>

                    <option value="Mahasiswa/Pelajar">
                        Mahasiswa/Pelajar
                    </option>

                    <option value="Lembaga/Instansi">
                        Lembaga/Instansi
                    </option>

                    <option value="Perorangan">
                        Perorangan
                    </option>

                </select>

            </div>
        </div>


        <hr>

        <div class="d-flex justify-content-end">

            <button
                type="button"
                class="btn btn-primary next"
            >
                Selanjutnya
            </button>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- STEP 2 --}}
    {{-- ========================================================= --}}

    <div id="step-2" class="form-step d-none">

        <h4 class="mb-0">
            Pertanyaan Survey
        </h4>

        <hr>


        {{-- PELAYANAN --}}
        <div class="mb-5">

            <label class="form-label fw-semibold">
                1. Bagaimana Pelayanan Petugas PPID Kami?
                <span class="text-danger">*</span>
            </label>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="pelayanan"
                    id="pelayanan-sangat-baik"
                    value="Sangat Baik"
                    required
                >
                <label
                    class="form-check-label"
                    for="pelayanan-sangat-baik"
                >
                    Sangat Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="pelayanan"
                    id="pelayanan-baik"
                    value="Baik"
                >
                <label
                    class="form-check-label"
                    for="pelayanan-baik"
                >
                    Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="pelayanan"
                    id="pelayanan-cukup"
                    value="Cukup Baik"
                >
                <label
                    class="form-check-label"
                    for="pelayanan-cukup"
                >
                    Cukup Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="pelayanan"
                    id="pelayanan-buruk"
                    value="Buruk"
                >
                <label
                    class="form-check-label"
                    for="pelayanan-buruk"
                >
                    Buruk
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="pelayanan"
                    id="pelayanan-sangat-buruk"
                    value="Sangat Buruk"
                >
                <label
                    class="form-check-label"
                    for="pelayanan-sangat-buruk"
                >
                    Sangat Buruk
                </label>
            </div>

        </div>


        {{-- KECEPATAN PELAYANAN --}}
        <div class="mb-5">

            <label class="form-label fw-semibold">
                2. Kecepatan Tindak Lanjut Permohonan
                <span class="text-danger">*</span>
            </label>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kecepatan_pelayanan"
                    id="kecepatan-sangat-baik"
                    value="Sangat Baik"
                    required
                >
                <label
                    class="form-check-label"
                    for="kecepatan-sangat-baik"
                >
                    Sangat Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kecepatan_pelayanan"
                    id="kecepatan-baik"
                    value="Baik"
                >
                <label
                    class="form-check-label"
                    for="kecepatan-baik"
                >
                    Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kecepatan_pelayanan"
                    id="kecepatan-cukup"
                    value="Cukup Baik"
                >
                <label
                    class="form-check-label"
                    for="kecepatan-cukup"
                >
                    Cukup Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kecepatan_pelayanan"
                    id="kecepatan-buruk"
                    value="Buruk"
                >
                <label
                    class="form-check-label"
                    for="kecepatan-buruk"
                >
                    Buruk
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kecepatan_pelayanan"
                    id="kecepatan-sangat-buruk"
                    value="Sangat Buruk"
                >
                <label
                    class="form-check-label"
                    for="kecepatan-sangat-buruk"
                >
                    Sangat Buruk
                </label>
            </div>

        </div>


        {{-- KESESUAIAN INFORMASI --}}
        <div class="mb-5">

            <label class="form-label fw-semibold">
                3. Kesesuaian Informasi Yang Kami Berikan
                <span class="text-danger">*</span>
            </label>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kesesuaian_informasi"
                    id="informasi-sangat-baik"
                    value="Sangat Baik"
                    required
                >
                <label
                    class="form-check-label"
                    for="informasi-sangat-baik"
                >
                    Sangat Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kesesuaian_informasi"
                    id="informasi-baik"
                    value="Baik"
                >
                <label
                    class="form-check-label"
                    for="informasi-baik"
                >
                    Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kesesuaian_informasi"
                    id="informasi-cukup"
                    value="Cukup Baik"
                >
                <label
                    class="form-check-label"
                    for="informasi-cukup"
                >
                    Cukup Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kesesuaian_informasi"
                    id="informasi-buruk"
                    value="Buruk"
                >
                <label
                    class="form-check-label"
                    for="informasi-buruk"
                >
                    Buruk
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kesesuaian_informasi"
                    id="informasi-sangat-buruk"
                    value="Sangat Buruk"
                >
                <label
                    class="form-check-label"
                    for="informasi-sangat-buruk"
                >
                    Sangat Buruk
                </label>
            </div>

        </div>


        {{-- KUALITAS PELAYANAN --}}
        <div class="mb-5">

            <label class="form-label fw-semibold">
                4. Kualitas Pelayanan PPID Pelaksana
                <span class="text-danger">*</span>
            </label>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kualitas_pelayanan"
                    id="kualitas-sangat-baik"
                    value="Sangat Baik"
                    required
                >
                <label
                    class="form-check-label"
                    for="kualitas-sangat-baik"
                >
                    Sangat Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kualitas_pelayanan"
                    id="kualitas-baik"
                    value="Baik"
                >
                <label
                    class="form-check-label"
                    for="kualitas-baik"
                >
                    Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kualitas_pelayanan"
                    id="kualitas-cukup"
                    value="Cukup Baik"
                >
                <label
                    class="form-check-label"
                    for="kualitas-cukup"
                >
                    Cukup Baik
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kualitas_pelayanan"
                    id="kualitas-buruk"
                    value="Buruk"
                >
                <label
                    class="form-check-label"
                    for="kualitas-buruk"
                >
                    Buruk
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="kualitas_pelayanan"
                    id="kualitas-sangat-buruk"
                    value="Sangat Buruk"
                >
                <label
                    class="form-check-label"
                    for="kualitas-sangat-buruk"
                >
                    Sangat Buruk
                </label>
            </div>

        </div>


        <hr>

        <div class="d-flex justify-content-between">

            <button
                type="button"
                class="btn btn-secondary back"
            >
                Kembali
            </button>

            <button
                type="button"
                class="btn btn-primary next"
            >
                Selanjutnya
            </button>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- STEP 3 --}}
    {{-- ========================================================= --}}

    <div id="step-3" class="form-step d-none">

        <h4 class="mb-0">
            Saran PPID
        </h4>

        <hr>

        <div class="mb-4">

            <label
                for="saran"
                class="form-label fw-semibold"
            >
                Saran Untuk PPID Kota Bontang
                <span class="text-danger">*</span>
            </label>

            <textarea
                name="saran"
                id="saran"
                class="form-control"
                rows="5"
                placeholder="Masukkan saran Anda..."
            ></textarea>

        </div>


        <hr>

        <div class="d-flex justify-content-between">

            <button
                type="button"
                class="btn btn-secondary back"
            >
                Kembali
            </button>

            <button
                type="submit"
                class="btn btn-success"
            >
                Selesai
            </button>

        </div>

    </div>


    {{-- PAGE INDICATOR --}}
    <div class="text-center mt-4">
        <span class="text-muted">
            Halaman
            <span id="current-page">1</span>
            dari 3
        </span>
    </div>

</form>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const steps = document.querySelectorAll('.form-step');
    const page = document.getElementById('current-page');

    let currentStep = 0;


    function showStep(index) {

        steps.forEach((step, i) => {
            step.classList.toggle('d-none', i !== index);
        });

        page.textContent = index + 1;

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }


    function validateCurrentStep() {

        const inputs = steps[currentStep].querySelectorAll(
            'input, select, textarea'
        );

        for (const input of inputs) {

            if (!input.checkValidity()) {
                input.reportValidity();
                return false;
            }

        }

        return true;
    }


    document.querySelectorAll('.next').forEach(button => {

        button.addEventListener('click', function () {

            if (!validateCurrentStep()) {
                return;
            }

            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }

        });

    });


    document.querySelectorAll('.back').forEach(button => {

        button.addEventListener('click', function () {

            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }

        });

    });


    showStep(currentStep);

});
</script>
</div>

@endsection