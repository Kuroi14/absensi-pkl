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
        Schema::create('izin_absensis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
    $table->date('tanggal');
    $table->enum('jenis', ['sakit','izin']);
    $table->text('keterangan')->nullable();
    $table->string('bukti')->nullable();
    $table->enum('status', ['pending','disetujui','ditolak'])->default('pending');
    $table->foreignId('approved_by')->nullable()->references('id')->on('gurus');
    $table->timestamp('approved_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_absensis');
    }
};
