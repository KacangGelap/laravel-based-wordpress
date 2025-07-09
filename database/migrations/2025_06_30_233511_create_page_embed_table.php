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
        Schema::create('page_embed_category', function (Blueprint $table){
            $table->id();
            $table->string('kategori');
            $table->timestamps();
        });
        Schema::create('page_embed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constraint('page_embed_category')->onDelete('cascade');
            $table->string('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_embed');
    }
};
