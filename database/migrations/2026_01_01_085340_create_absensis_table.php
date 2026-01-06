<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->decimal('check_in_lat',10,7)->nullable();
            $table->decimal('check_in_lng',10,7)->nullable();
            $table->decimal('check_out_lat',10,7)->nullable();
            $table->decimal('check_out_lng',10,7)->nullable();
            $table->string('check_in_foto')->nullable();
            $table->string('check_out_foto')->nullable();
            $table->string('status')->default('hadir');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
