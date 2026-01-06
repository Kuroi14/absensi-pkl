<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tempat_pkls', function (Blueprint $table) {
    $table->decimal('latitude', 10, 7)->after('alamat');
    $table->decimal('longitude', 10, 7)->after('latitude');
    $table->integer('radius')->default(100)->after('longitude');
});

    }

    public function down(): void
    {
        Schema::table('tempat_pkls', function (Blueprint $table) {
            $table->dropColumn(['latitude','longitude','radius']);
        });
    }
};
