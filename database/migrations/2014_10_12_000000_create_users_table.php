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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique();
            $table->string('no_hp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role',['admin','editor','contributor'])->default('editor');
            $table->enum('opd',['Diskominfo','Korpri','Pkk','Setda','Setwan','Itda','DIsdikbud','Dinkes','Dpupr','Dpkpp','Dpkp','Dspm','Dpmptsp','Disnaker','Dlh','Disdukcapil','Dishub','Disporapar','Dkukmp','Dpk','Dkppp','Dppkb','Satpol PP','Bkpsdm','Bapperinda','Bapenda','Bpkad','Bakesbangpol','Bpbd','Rsud','Ukpbj','Puskesmas Bontang Selatan 1','Puskesmas Bontang Selatan 2','Puskesmas Bontang Utara 1','Puskesmas Bontang Utara 2','Puskesmas Bontang Barat','Puskesmas Bontang Lestari','Laboratorium Kesehatan','Kec-Bontang Barat','Kec-Bontang Utara','Kec-Bontang Selatan','Kel-Kanaan','Kel-Belimbing','Kel-Gunung Telihan','Kel-Bontang Baru','Kel-Api-Api','Kel-Gunung Elai','Kel-Guntung','Kel-Loktuan','Kel-Tanjung Laut','Kel-Tanjung Laut Indah','Kel-Berbas Tengah','Kel-Berbas Pantai','Kel-Satimpo','Kel-Bontang Lestari']);
            $table->string('password');
            $table->longText('profile')->charset('binary')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
