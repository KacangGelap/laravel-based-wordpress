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
        Schema::create('permohonan_informasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_permohonan')->unique();
            $table->enum('kategori_permohonan', ['Mahasiswa/Pelajar','Lembaga/Instansi','Perorangan']);
            $table->foreignId('opd_id')->constrained('opd')->onDelete('cascade');
            $table->string('nama_pemohon');
            $table->enum('jenis_identitas', [
                'KTP',
                'Nomor Badan Hukum',
                'Nomor Surat Mahasiswa'
            ]);
            $table->string('nomor_identitas');
            $table->string('alamat_pemohon');
            $table->string('pekerjaan_pemohon');
            $table->string('hp_pemohon');
            $table->string('rincian_kebutuhan');
            $table->string('tujuan_informasi');
            $table->enum('cara_memperoleh_informasi', ['Mendapat salinan hardcopy/softcopy', 'Melihat/Membaca/Mendegarakan/Mencatat']);
            $table->enum('cara_mendapatkan_informasi', ['WhatsApp', 'Email','Fax','Jasa Expedisi','Mengambil Langsung']);
            $table->string('identitas'); //file path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_informasi');
    }
};
