<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {

            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();

            $table->decimal('lat_in', 10, 7)->nullable();
            $table->decimal('lng_in', 10, 7)->nullable();

            $table->decimal('lat_out', 10, 7)->nullable();
            $table->decimal('lng_out', 10, 7)->nullable();

            $table->string('foto_in')->nullable();
            $table->string('foto_out')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn([
                'check_in','check_out',
                'lat_in','lng_in',
                'lat_out','lng_out',
                'foto_in','foto_out'
            ]);
        });
    }
};
