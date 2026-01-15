<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('gurus', function (Blueprint $table) {
        $table->string('jenis_ketenagaan')->nullable();
        $table->text('alamat')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('gurus', function (Blueprint $table) {
        $table->dropColumn(['jenis_ketenagaan','alamat']);
    });
}
};
