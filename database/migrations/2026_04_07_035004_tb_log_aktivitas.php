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
        //
        Schema::create('tb_log_aktivitas', function (Blueprint $table) {
            $table->increments("id_log");
            $table->integer("id_user")->unsigned();
            $table->string('aktivitas', 100);
            $table->datetime('waktu_aktivitas');

            $table->foreign("id_user")->references('id_user')->on('tb_user')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("tb_log_aktivitas");
    }
};
