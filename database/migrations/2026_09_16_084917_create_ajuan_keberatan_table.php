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
        Schema::create('ajuan_keberatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ajuan')->unique();
            $table->enum('alasan_keberatan', [
    'Biaya yang dikenakan tidak wajar',
    'Data yang diberikan tidak valid',
    'Permintaan informasi ditanggapi tidak sebagaimana diminta',
    'Informasi tidak ditanggapi',
    'Permohonan informasi ditolak',
]);
            $table->string('nama_pemohon');
            $table->string('alamat');
            $table->string('hp_pemohon');
            $table->string('rincian_keberatan');
            $table->string('identitas'); //file path    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajuan_keberatan');
    }
};
