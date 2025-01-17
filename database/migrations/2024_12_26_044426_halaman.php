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
        // // Create the menus table
        // Schema::create('menus', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('menu');
        //     $table->timestamps();
        // });

        // // Create the sub_menus table
        // Schema::create('sub_menus', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
        //     $table->string('sub_menu');
        //     $table->enum('type', ['page', 'dropdown','link']);
        //     $table->enum('filetype', ['foto', 'video', 'pdf'])->nullable();
        //     $table->longText('media')->charset('binary')->nullable();
        //     $table->string('youtube');
        //     $table->string('link');
        //     $table->timestamps();
        // });

        // // Create the sub_sub_menus table
        // Schema::create('sub_sub_menus', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('sub_menu_id')->constrained('sub_menus')->onDelete('cascade');
        //     $table->string('sub_sub_menu');
        //     $table->enum('type', ['page', 'dropdown', 'link']);
        //     $table->enum('filetype', ['foto', 'video', 'pdf'])->nullable();
        //     $table->longText('media')->charset('binary')->nullable();
        //     $table->string('youtube');
        //     $table->string('link');
        //     $table->timestamps();
        // });
        // Schema::create('halaman',function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
        //     $table->foreignId('sub_menu_id')->constrained('sub_menus')->onDelete('cascade');
        //     $table->foreignId('sub_sub_menu_id')->constrained('sub_sub_menus')->onDelete('cascade')->nullable();
        //     $table->foreignId('sub_sub_sub_menu_id')->constrained('sub_sub_sub_menus')->onDelete('cascade')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
