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
        //
        \DB::statement("ALTER TABLE sub_sub_sub_menus MODIFY type ENUM('dropdown','page','link','id.pdupt')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
