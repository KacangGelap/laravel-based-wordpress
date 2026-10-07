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
       \DB::statement("ALTER TABLE permohonan_informasi MODIFY jenis_permohonan VARCHAR(255)");
       \DB::statement("ALTER TABLE permohonan_informasi MODIFY cara_mendapatkan_informasi ENUM('WhatsApp','Email','Fotocopy','Jasa Expedisi','Mengambil Langsung')");
       Schema::table('permohonan_informasi', function (Blueprint $table) {
            $table->string('nomor_identitas')->nullable()->change();
            $table->string('alamat_pemohon')->nullable()->change();
            $table->string('pekerjaan_pemohon')->nullable()->change();
            $table->string('hp_pemohon')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_informasi', function (Blueprint $table) {
            $table->string('nomor_identitas')->nullable(false)->change();
            $table->string('alamat_pemohon')->nullable(false)->change();
            $table->string('pekerjaan_pemohon')->nullable(false)->change();
            $table->string('hp_pemohon')->nullable(false)->change();
        });
        \DB::statement("ALTER TABLE permohonan_informasi MODIFY cara_mendapatkan_informasi ENUM('WhatsApp','Email','Fax','Jasa Expedisi','Mengambil Langsung')");
        \DB::statement("ALTER TABLE permohonan_informasi MODIFY jenis_permohonan ENUM('KTP','Nomor Badan Hukum','Nomor Surat Mahasiswa')");
    }
};
