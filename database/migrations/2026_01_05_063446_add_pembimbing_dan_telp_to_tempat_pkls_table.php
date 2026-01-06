<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tempat_pkls', function (Blueprint $table) {
            $table->string('pembimbing')->nullable()->after('alamat');
            $table->string('telp')->nullable()->after('pembimbing');
        });
    }

    public function down(): void
    {
        Schema::table('tempat_pkls', function (Blueprint $table) {
            $table->dropColumn(['pembimbing','telp']);
        });
    }
};
