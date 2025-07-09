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
        Schema::create('advanced_carousel_category', function (Blueprint $table){
            $table->id();
            $table->string('kategori');
            $table->timestamps();
        });
        Schema::create('advanced_carousel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('advanced_carousel_category')->onDelete('cascade');
            $table->string('judul');
            $table->string('media');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advanced_carousel');
    }
};
