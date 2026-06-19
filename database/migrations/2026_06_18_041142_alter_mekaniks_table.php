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
        Schema::table('mekaniks', function (Blueprint $table) {
            $table->string('npk')->after('id')->nullable();
            $table->renameColumn('spesialisasi', 'jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mekaniks', function (Blueprint $table) {
            $table->renameColumn('jabatan', 'spesialisasi');
            $table->dropColumn('npk');
        });
    }
};
