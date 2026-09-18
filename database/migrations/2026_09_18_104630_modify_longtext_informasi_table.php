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
        \DB::statement("ALTER TABLE permohonan_informasi MODIFY COLUMN rincian_kebutuhan LONGTEXT");
        \DB::statement("ALTER TABLE permohonan_informasi MODIFY COLUMN tujuan_informasi LONGTEXT");
        \DB::statement("ALTER TABLE ajuan_keberatan MODIFY COLUMN rincian_keberatan LONGTEXT");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
