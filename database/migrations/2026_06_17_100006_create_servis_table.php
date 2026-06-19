<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servis', function (Blueprint $table) {
            $table->id();
            $table->string('no_servis')->unique();
            $table->foreignId('motor_id')->constrained('motors')->cascadeOnDelete();
            $table->foreignId('mekanik_id')->nullable()->constrained('mekaniks')->nullOnDelete();
            $table->dateTime('tanggal_masuk');
            $table->dateTime('tanggal_keluar')->nullable();
            $table->text('keluhan');
            $table->text('diagnosa')->nullable();
            $table->enum('status', ['dikerjakan', 'selesai', 'diambil'])->default('dikerjakan');
            $table->decimal('biaya_jasa', 12, 2)->default(0);
            $table->decimal('total_biaya', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servis');
    }
};
