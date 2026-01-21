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
        Schema::create('koreksi_absensis', function (Blueprint $table) {
    $table->id();

    $table->foreignId('absensi_id')
          ->constrained('absensis')
          ->cascadeOnDelete();

    $table->foreignId('siswa_id')
          ->constrained('siswas')
          ->cascadeOnDelete();

    $table->date('tanggal');

    // DATA KOREKSI
    $table->time('check_in_time')->nullable();
    $table->time('check_out_time')->nullable();

    $table->decimal('lat_in', 10, 7)->nullable();
    $table->decimal('lng_in', 10, 7)->nullable();
    $table->decimal('lat_out', 10, 7)->nullable();
    $table->decimal('lng_out', 10, 7)->nullable();

    $table->string('foto_in')->nullable();
    $table->string('foto_out')->nullable();

    // STATUS PERSETUJUAN
    $table->enum('status', [
        'pending',
        'disetujui',
        'ditolak'
    ])->default('pending');

    // ALASAN KOREKSI
    $table->text('alasan')->nullable();

    // DISETUJUI OLEH
    $table->foreignId('approved_by')
          ->nullable()
          ->constrained('users')
          ->nullOnDelete();

    $table->timestamp('approved_at')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koreksi_absensis');
    }
};
