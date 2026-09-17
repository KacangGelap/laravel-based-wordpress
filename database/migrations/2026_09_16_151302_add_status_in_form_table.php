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
        Schema::table('permohonan_informasi', function (Blueprint $table) {
            $table->enum('status', ['Dikirim', 'Diproses', 'Ditolak ', 'Selesai'])->default('Dikirim')->after('id');
        });
        Schema::table('ajuan_keberatan', function (Blueprint $table) {
            $table->enum('status', ['Dikirim', 'Diproses', 'Ditolak ', 'Selesai'])->default('Dikirim')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_informasi', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('ajuan_keberatan', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
