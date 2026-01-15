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
        Schema::create('absensi_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
    $table->date('tanggal');
    $table->double('jarak');
    $table->string('keterangan');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_logs');
    }
};
