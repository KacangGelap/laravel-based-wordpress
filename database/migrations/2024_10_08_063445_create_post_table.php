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
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->timestamps();
        });
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('media1');
            $table->string('media2')->nullable();
            $table->string('media3')->nullable();
            $table->string('media4')->nullable();
            $table->longText('deskripsi');
            $table->foreignId('kategori_id')->nullable()->constrained(
                table:'kategori', indexName:'kategori_post_id'
            )->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained(
                table: 'users', indexName: 'author_id'
            )->nullOnDelete();
            $table->string('contributor')->nullable();
            $table->integer('pengunjung')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
