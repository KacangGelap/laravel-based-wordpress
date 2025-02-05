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
        Schema::create('filecat', function (Blueprint $table) {
            $table->id();
            $table->string('cat');
            $table->timestamps();
        });
        Schema::create('unduh', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('media');
            $table->foreignId('filecat_id')->constrained('filecat')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unduh');
    }
};
