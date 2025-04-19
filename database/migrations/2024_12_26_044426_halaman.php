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
        // Create the menus table
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu');
            $table->timestamps();
        });

        // Create the sub_menus table
        Schema::create('sub_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->string('sub_menu');
            $table->enum('type', ['page', 'dropdown','link','id.pdupt']);
            $table->enum('filetype', ['foto', 'video', 'pdf'])->nullable();
            $table->string('media')->nullable();
            $table->string('tambahan1')->nullable();
            $table->string('tambahan2')->nullable();
            $table->string('tambahan3')->nullable();
            $table->string('yt_id')->nullable();
            $table->string('link')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('wa')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('x')->nullable();
            $table->longText('maps')->nullable();
            $table->longText('text')->nullable();
            $table->timestamps();
        });

        // Create the sub_sub_menus table
        Schema::create('sub_sub_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_menu_id')->constrained('sub_menus')->onDelete('cascade');
            $table->string('sub_sub_menu');
            $table->enum('type', ['page', 'dropdown','link','id.pdupt']);
            $table->enum('filetype', ['foto', 'video', 'pdf'])->nullable();
            $table->string('media')->nullable();
            $table->string('tambahan1')->nullable();
            $table->string('tambahan2')->nullable();
            $table->string('tambahan3')->nullable();
            $table->string('yt_id')->nullable();
            $table->string('link')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('wa')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('x')->nullable();
            $table->longText('maps')->nullable();
            $table->longText('text')->nullable();
            $table->timestamps();
        });
        // Create the sub_sub_sub_menus table
        Schema::create('sub_sub_sub_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_sub_menu_id')->constrained('sub_sub_menus')->onDelete('cascade');
            $table->string('sub_sub_sub_menu');
            $table->enum('type', ['dropdown','page','link','id.pdupt']);
            $table->enum('filetype', ['foto', 'video', 'pdf'])->nullable();
            $table->string('media')->nullable();
            $table->string('tambahan1')->nullable();
            $table->string('tambahan2')->nullable();
            $table->string('tambahan3')->nullable();
            $table->string('yt_id')->nullable();
            $table->string('link')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('wa')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('x')->nullable();
            $table->longText('maps')->nullable();
            $table->longText('text')->nullable();
            $table->timestamps();
        });
        // Schema::create('sub_sub_sub_sub_menus', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('sub_sub_sub_menu_id')->constrained('sub_sub_sub_menus')->onDelete('cascade');
        //     $table->string('sub_sub_sub_sub_menu');
        //     $table->enum('type', ['page','link','id.pdupt']);
        //     $table->enum('filetype', ['foto', 'video', 'pdf'])->nullable();
        //     $table->string('media')->nullable();
        //     $table->string('tambahan1')->nullable();
        //     $table->string('tambahan2')->nullable();
        //     $table->string('tambahan3')->nullable();
        //     $table->string('yt_id')->nullable();
        //     $table->string('link')->nullable();
        //     $table->string('alamat')->nullable();
        //     $table->string('telp')->nullable();
        //     $table->string('wa')->nullable();
        //     $table->string('fax')->nullable();
        //     $table->string('email')->nullable();
        //     $table->string('website')->nullable();
        //     $table->string('instagram')->nullable();
        //     $table->string('facebook')->nullable();
        //     $table->string('youtube')->nullable();
        //     $table->string('tiktok')->nullable();
        //     $table->string('x')->nullable();
        //     $table->longText('maps')->nullable();
        //     $table->longText('text')->nullable();
        //     $table->timestamps();
        // });
        Schema::create('halaman',function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->foreignId('sub_menu_id')->constrained('sub_menus')->onDelete('cascade');
            $table->foreignId('sub_sub_menu_id')->nullable()->constrained('sub_sub_menus')->onDelete('cascade');
            $table->foreignId('sub_sub_sub_menu_id')->nullable()->constrained('sub_sub_sub_menus')->onDelete('cascade');
            // $table->foreignId('sub_sub_sub_sub_menu_id')->nullable()->constrained('sub_sub_sub_sub_menus')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
