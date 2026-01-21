<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->foreignId('guru_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->foreignId('tempat_pkl_id')
          ->nullable()
          ->constrained('tempat_pkls')
          ->nullOnDelete();

    $table->string('nis');
    $table->string('nama');
    $table->string('kelas');

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
