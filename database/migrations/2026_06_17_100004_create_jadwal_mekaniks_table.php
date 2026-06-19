<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_mekaniks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mekanik_id')->constrained('mekaniks')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('shift', ['pagi', 'siang', 'sore']);
            $table->enum('status', ['hadir', 'izin', 'cuti'])->default('hadir');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['mekanik_id', 'tanggal', 'shift']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_mekaniks');
    }
};
