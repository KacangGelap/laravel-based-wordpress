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
        // Create the sub_sub_sub_menus table
        Schema::create('sub_sub_sub_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_sub_menu_id')->constrained('sub_sub_menus')->onDelete('cascade');
            $table->string('sub_sub_sub_menu');
            $table->enum('type', ['page','link']);
            $table->enum('filetype', ['foto', 'video', 'pdf'])->nullable();
            $table->longText('media')->charset('binary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_sub_sub_menus');
    }
};
