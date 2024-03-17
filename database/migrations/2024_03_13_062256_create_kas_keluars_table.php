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
        Schema::create('kas_keluars', function (Blueprint $table) {
            $table->id('id_kaskeluar');
            $table->string('nm_pj_klr');
            $table->date('tgl_input');
            $table->string('nominal');
            $table->string('ket');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_keluars');
    }
};
