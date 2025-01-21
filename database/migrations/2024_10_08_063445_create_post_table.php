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
        // Schema::create('kategori', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('kategori');
        // });
        // Schema::create('post', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('judul');
        //     $table->longText('media1')->charset('binary');
        //     $table->longText('media2')->charset('binary')->nullable();
        //     $table->longText('media3')->charset('binary')->nullable();
        //     $table->longText('deskripsi1');
        //     $table->longText('deskripsi2')->nullable();
        //     $table->longText('deskripsi3')->nullable();
        //     $table->foreignId('kategori_id')->constrained(
        //         table:'kategori', indexName:'kategori_post_id'
        //     );
        //     $table->foreignId('user_id')->constrained(
        //         table:'users', indexName:'author_id'
        //     )->nullable();
        //     $table->string('contributor')->nullable();
        //     $table->integer('pengunjung')->default(0);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
