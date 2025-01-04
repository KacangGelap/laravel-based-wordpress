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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('date'); // The date for the statistics
            $table->unsignedInteger('visitors')->default(0); // Number of unique visitors
            $table->unsignedInteger('page_views')->default(0); // Number of page views
            $table->timestamps(); // Created at and updated at timestamps
            $table->unique('date'); // Ensure only one record per date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic');
    }
};
