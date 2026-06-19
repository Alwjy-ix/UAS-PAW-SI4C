<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->cascadeOnDelete();
            $table->string('no_polisi')->unique();
            $table->string('merk')->default('Honda');
            $table->string('tipe_motor');
            $table->year('tahun_pembuatan')->nullable();
            $table->string('no_rangka')->nullable()->unique();
            $table->string('no_mesin')->nullable()->unique();
            $table->string('warna')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
