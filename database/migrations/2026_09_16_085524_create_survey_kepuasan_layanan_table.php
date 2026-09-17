<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_kepuasan_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('usia',['> 30 Tahun','25 - 30 Tahun', '18 - 25 Tahun', '< 18 Tahun']);
            $table->string('email');
            $table->enum('kategori_responden', ['Mahasiswa/Pelajar','Lembaga/Instansi','Perorangan']);
            $table->enum('pelayanan', ['Sangat Baik', 'Baik', 'Cukup Baik', 'Buruk', 'Sangat Buruk']);
            $table->enum('kecepatan_pelayanan', ['Sangat Baik', 'Baik', 'Cukup Baik', 'Buruk', 'Sangat Buruk']);
            $table->enum('kesesuaian_informasi', ['Sangat Baik', 'Baik', 'Cukup Baik', 'Buruk', 'Sangat Buruk']);
            $table->enum('kualitas_pelayanan', ['Sangat Baik', 'Baik', 'Cukup Baik', 'Buruk', 'Sangat Buruk']);
            $table->string('saran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_kepuasan_layanan');
    }
};
